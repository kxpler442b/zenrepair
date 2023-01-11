<?php

/**
 * Library for Okta authentication functions.
 * 
 * Adapted from 'https://developer.okta.com/blog/2018/12/28/simple-login-php'
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 11/01/23
 * 
 * @author B Moss
 */

declare(strict_types = 1);

namespace App\Libraries;

class OktaApi
{
    protected $container;

    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $metadataUrl;
    private $apiToken;
    private $apiUrlBase;

    public function __construct(\Psr\Container\ContainerInterface $container, array $settings)
    {
        $this->container = $container;

        $this->clientId = $settings['CLIENT_ID'];
        $this->clientSecret = $settings['CLIENT_SECRET'];
        $this->redirectUri = $settings['REDIRECT_URI'];
        $this->metadataUrl = $settings['METADATA_URL'];
        $this->apiToken = $settings['API_TOKEN'];
        $this->apiUrlBase = $settings['API_URL_BASE'];
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