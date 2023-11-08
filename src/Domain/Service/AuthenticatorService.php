<?php

declare(strict_types = 1);

namespace App\Domain\Service;

use Carbon\Carbon;
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

        $this->logger->debug('Attempting to authenticate a user.', [$user]);

        if($user == null || !password_verify($credentials->password, $user->getPassword())) {
            $this->logger->debug('A user failed to authenticate.', [$user, $credentials->password, $user->getPassword]);

            return AuthEnum::AUTH_FAILED;
        }

        $token = $this->tokens->create($user);

        $encodedData = $this->sessionDataEncoder([
            'zenrepair_session_auth' => $token->getId(),
            'zenrepair_user' => $user->getId()
        ]);

        $this->session->set('zenrepair_session_auth', $encodedData['zenrepair_session_auth']);
        $this->session->set('zenrepair_user', $encodedData['zenrepair_user']);

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

        $decodedData = $this->sessionDataDecoder([
            'zenrepair_session_auth' => $encodedTokenId,
            'zenrepair_user' => $encodedUserId
        ]);

        $token = $this->tokens->findOneBy(['id' => $decodedData['zenrepair_session_auth']]);
        $user = $this->users->findOneBy(['id' => $decodedData['zenrepair_user']]);

        if($token == null 
            || $token->getExpires()->lessThanOrEqualTo(new Carbon('now')) 
            || !$token->getOwner() == $user) {
                
            $this->clearSessionStorage();

            return AuthEnum::AUTH_FAILED;
        }

        return AuthEnum::AUTH_SUCCESS;
    }

    public function logout(): void
    {
        $encodedTokenId = $this->session->get('zenrepair_session_auth');

        $decodedData = $this->sessionDataDecoder([
            'zenrepair_session_auth' => $encodedTokenId
        ]);

        $token = $this->tokens->findOneBy(['id' => $decodedData['zenrepair_session_auth']]);

        $this->tokens->delete($token);
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

    public function sessionDataEncoder(array $data): array
    {
        $encodedData = [];

        foreach($data as $key => $value) {
            $encodedData[$key] = base64_encode($value);
        }

        return $encodedData;
    }

    public function sessionDataDecoder(array $data): array
    {
        $decodedData = [];

        foreach($data as $key => $value) {
            $decodedData[$key] = base64_decode($value);
        }

        return $decodedData;
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