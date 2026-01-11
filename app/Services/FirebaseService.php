<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseService
{
    protected Auth $auth;

    public function __construct()
    {
        $credentials = env('FIREBASE_CREDENTIALS');

        if (!$credentials) {
            throw new \Exception('FIREBASE_CREDENTIALS is not set in environment.');
        }

        $factory = (new Factory)
            ->withServiceAccount(json_decode($credentials, true));

        $this->auth = $factory->createAuth();
    }

    public function createUser($email, $password)
    {
        return $this->auth->createUser([
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function sendEmailVerification($email)
    {
        return $this->auth->getEmailVerificationLink($email);
    }

    public function getUserByEmail($email)
    {
        return $this->auth->getUserByEmail($email);
    }
}
