<?php

declare(strict_types = 1);

namespace App\Authenticator;

use Random\Engine\Secure;
use App\Service\UserService;
use App\Domain\Enum\AuthEnum;
use Doctrine\ORM\EntityManager;
use App\Support\Settings\Settings;
use Odan\Session\SessionInterface;
use App\Domain\Entity\AuthTokenEntity;
use App\Domain\Repository\AuthTokenRepository;
use App\Domain\XferObject\UserCredentialsObject;

/**
 * zenRepair local authorization mechanism.
 */
final class Authenticator
{
    private UserService $users;
    private AuthTokenRepository $tokens;
    private SessionInterface $session;
    private string $algorithm;
    private array $options;

    public function __construct(UserService $userService, EntityManager $em, SessionInterface $session, Settings $settings)
    {
        $this->users = $userService;
        $this->session = $session;
        $this->tokens = $em->getRepository('AuthTokenEntity');
        $this->algorithm = $settings->get('authenticator.crypto.algorithm');
        $this->options = $settings->get('authenticator.crypto.options');
    }

    /**
     * Attempts to authorize a user with the provided credentials.
     *
     * @param UserCredentialsObject $credentials
     * @return AuthEnum
     */
    public function login(UserCredentialsObject $credentials): AuthEnum
    {
        $user = $this->users->find(['username', $credentials->username]);

        if($user == null || !password_verify($credentials->password, $user->getPassword())) {
            return AuthEnum::AUTH_FAILED;
        }

        $this->clearSessionStorage();

        $token = $this->createAuthTokenObject();

        $this->session->set('authStorage', [
            'token' => $token->getHash()
        ]);

        return AuthEnum::AUTH_SUCCESS;
    }

    /**
     * Attemps to verify a user's authorization status using the stored authorization token.
     *
     * @return AuthEnum
     */
    public function verify(): AuthEnum
    {
        if(!$this->session->has('authStore')) {
            return AuthEnum::AUTH_FAILED;
        }

        $token = $this->tokens->findByHash($this->session->get('authStore')['token']);

        if($token == null) {
            $this->clearSessionStorage();

            return AuthEnum::AUTH_FAILED;
        }

        return AuthEnum::AUTH_SUCCESS;
    }

    /**
     * Creates a password hash from the provided password.
     *
     * @param string $password
     * @return string
     */
    public function createPasswordHash(string $password): string
    {
        return password_hash(
            $password,
            $this->algorithm,
            $this->options
        );
    }

    /**
     * Creates a new authorization token.
     *
     * @return AuthTokenEntity
     */
    private function createAuthTokenObject(): AuthTokenEntity
    {
        return (new AuthTokenEntity)
            ->setHash((new Secure())->generate());
    }

    /**
     * Clears the client's authorization storage.
     *
     * @return void
     */
    private function clearSessionStorage(): void
    {
        if($this->session->has('authStorage')) {
            $this->session->delete('authStorage');
        }
    }
}