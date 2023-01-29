<?php

/**
 * Authentication service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Services;

use App\Config;
use App\Controllers\AuthController;

use Psr\Container\ContainerInterface;

class AuthService
{
    protected AuthController $authController;
    protected ContainerInterface $container;

    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $metadataUrl;
    private $apiToken;
    private $apiUrlBase;

    public function __construct(AuthController $authController, Config $config)
    {
        $this->authController = $authController;
        $this->container = $authController->getContainer();

        $this->clientId = $config->get('okta.client_id');
        $this->clientSecret =$config->get('okta.client_secret');
        $this->redirectUri = $config->get('okta.redirect_uri');
        $this->metadataUrl = $config->get('okta.metadata_url');
        $this->apiToken = $config->get('okta.api_token');
        $this->apiUrlBase = $config->get('okta.api_base_url');
    }

    public function getController() : AuthController
    {
        return $this->authController;
    }

    public function buildAuthorizeUrl($state)
    {
        $metadata = $this->httpRequest($this->metadataUrl);
        $url = $metadata->authorization_endpoint . '?' . http_build_query([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'state' => $state,
            'scope' => 'openid',
        ]);
        return $url;
    }

    public function authorizeUser()
    {
        if ($_SESSION['state'] != $_GET['state']) {
            $result['error'] = true;
            $result['errorMessage'] = 'Authorization server returned an invalid state parameter';
            return $result;
        }

        if (isset($_GET['error'])) {
            $result['error'] = true;
            $result['errorMessage'] = 'Authorization server returned an error: '.htmlspecialchars($_GET['error']);
            return $result;
        }

        $metadata = $this->httpRequest($this->metadataUrl);

        $response = $this->httpRequest($metadata->token_endpoint, [
            'grant_type' => 'authorization_code',
            'code' => $_GET['code'],
            'redirect_uri' => $this->redirectUri,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ]);

        if (! isset($response->access_token)) {
            $result['error'] = true;
            $result['errorMessage'] = 'Error fetching access token!';
            return $result;
        }
        $_SESSION['access_token'] = $response->access_token;

        $token = $this->httpRequest($metadata->introspection_endpoint, [
            'token' => $response->access_token,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ]);

        if ($token->active == 1) {
            $_SESSION['username'] = $token->username;
            $result['success'] = true;
            return $result;
        }
    }

    public function checkAuthStatus() : bool
    {
        if (isset($_SESSION['username']))
        {
            return True;
        }
        else
        {
            return False;
        }
    }

    private function httpRequest(string $url, array $params = [])
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($params)
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        return json_decode(curl_exec($ch));
    }
}