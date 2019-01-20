<?php

namespace App\Oauth\Storage;

use Illuminate\Support\Facades\Auth;
use OAuth2\Storage\UserCredentialsInterface;

class MedusaUserCredentials implements UserCredentialsInterface
{
    public function checkUserCredentials($username, $password)
    {
        return Auth::attempt([
            'email_address' => strtolower(str_replace(' ', '+', $username)),
            'password'      => $password,
            'active'        => 1,
        ]);
    }

    public function getUserDetails($username)
    {
        return ['user_id' => $username];
    }
}
