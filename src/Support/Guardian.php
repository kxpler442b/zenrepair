<?php

/**
 * User authentication system.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 23/03/23
 */

declare(strict_types = 1);

namespace App\Support;

use Carbon\Carbon;
use App\Domain\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class Guardian
{
    protected string $privateKey;
    protected string $publicKey;
    
    public function __construct(array $keys)
    {
        $this->privateKey = $keys['private_key'];
        $this->publicKey = $keys['public_key'];
    }

    public function authenticate(User $user, $password): ?string
    {
        if (!password_verify($password, $user->getPassword()))
        {
            return null;
        }

        $dt = new Carbon('now');

        $payload = [
            'iss' => BASE_URL,
            'iat' => $dt->getTimestamp(),
            'exp' => $dt->addMinutes(30)->getTimestamp(),
            'given_name' => $user->getFirstName(),
            'family_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'updated_at' => $user->getUpdated()->getTimestamp()
        ];

        return $this->encodeToken($payload);
    }

    public function verify(?string $jwt): bool
    {
        try {
            $this->decodeToken($jwt);
        }
        catch(SignatureInvalidException $sigInvalid)
        {
            return false;
        }
        catch(ExpiredException $expired)
        {
            return false;
        }

        return true;
    }

    public function deauthenticate()
    {

    }

    private function encodeToken(array $payload): string
    {
        return JWT::encode($payload, $this->privateKey, 'EdDSA');
    }

    private function decodeToken(string $jwt)
    {
        return JWT::decode($jwt, new Key($this->publicKey, 'EdDSA'));
    }
}