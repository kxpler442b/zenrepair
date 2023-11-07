<?php

declare(strict_types = 1);

namespace App\Domain\Service;

use Psr\Log\LoggerInterface;
use App\Domain\Enum\AuthEnum;
use Doctrine\ORM\EntityManager;
use App\Domain\Entity\UserEntity;
use Odan\Session\SessionInterface;
use App\Domain\Entity\AuthTokenEntity;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\AuthTokenRepository;
use App\Domain\XferObject\UserCredentialsObject;
use Doctrine\DBAL\Driver\Mysqli\Initializer\Secure;

final class AuthenticatorService extends Service
{
    private UserRepository $users;
    private AuthTokenRepository $tokens;
    private SessionInterface $session;
    private string $algorithm;
    private array $options;

    public function __construct(
        EntityManager $em,
        SessionInterface $session,
        LoggerInterface $logger,
        string $algorithm,
        array $options
    ) {
        $this->users = $em->getRepository(UserEntity::class);
        $this->tokens = $em->getRepository(AuthTokenEntity::class);
        $this->session = $session;
        $this->algorithm = $algorithm;
        $this->options = $options;

        parent::__construct($logger);
    }

    /**
     * Attempts to authorize a user with the provided credentials.
     *
     * @param UserCredentialsObject $credentials
     * @return AuthEnum
     */
    public function login(UserCredentialsObject $credentials): AuthEnum
    {
        $this->clearSessionStorage();

        $user = $this->users->findOneBy(['username' => $credentials->username]);

        if($user == null || !password_verify($credentials->password, $user->getPassword())) {
            return AuthEnum::AUTH_FAILED;
        }

        $token = $this->tokens->new($user);
        $this->tokens->save($token);

        $encodedData = $this->sessionDataEncoder($token->getId(), $user->getId());

        $this->session->set('zenrepair_session_auth', $encodedData['encodedTokenId']);
        $this->session->set('zenrepair_user', $encodedData['encodedUserId']);

        return AuthEnum::AUTH_SUCCESS;
    }

    /**
     * Attemps to verify a user's authorization status using the stored authorization token.
     *
     * @return AuthEnum
     */
    public function verify(): AuthEnum
    {
        if(!$this->session->has('zenrepair_session_auth')) {
            return AuthEnum::AUTH_FAILED;
        }

        $encodedTokenId = $this->session->get('zenrepair_session_auth');
        $encodedUserId = $this->session->get('zenrepair_user');

        $decodedData = $this->sessionDataDecoder($encodedTokenId, $encodedUserId);

        $token = $this->tokens->findOneBy(['id' => $decodedData['decodedTokenId']]);
        $user = $this->users->findOneBy(['id' => $decodedData['decodedUserId']]);

        if($token == null || !$token->getOwner() == $user) {
            $this->clearSessionStorage();

            return AuthEnum::AUTH_FAILED;
        }

        return AuthEnum::AUTH_SUCCESS;
    }

    public function createUser(UserCredentialsObject $credentials): void
    {
        $hashedPassword = $this->createPasswordHash($credentials->password);
        $credentials->password = $hashedPassword;

        $user = $this->users->new($credentials);

        $this->users->save($user);
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

    public function sessionDataEncoder(string $tokenId, string $userId): array
    {
        return [
            'encodedTokenId' => base64_encode($tokenId),
            'encodedUserId' => base64_encode($userId)
        ];
    }

    public function sessionDataDecoder(string $encodedTokenId, string $encodedUserId): array
    {
        return [
            'decodedTokenId' => base64_decode($encodedTokenId),
            'decodedUserId' => base64_decode($encodedUserId)
        ];
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