<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseService
{
    protected Auth $auth;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('firebase.json'));

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
        return $this->auth->sendEmailVerificationLink($email);
    }

    public function getUserByEmail($email)
    {
        return $this->auth->getUserByEmail($email);
    }
}
