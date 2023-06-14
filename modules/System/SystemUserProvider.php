<?php

namespace VuongCMS\System;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use VuongCMS\Common\Models\Account;

class SystemUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {}

    public function retrieveByToken($identifier, $token)
    {}

    public function updateRememberToken(Authenticatable $user, $token)
    {}

    public function retrieveByCredentials(array $credentials)
    {
        // Use $credentials to get the user data, and then return an object implements interface `Illuminate\Contracts\Auth\Authenticatable` 
        $account = Account::where('email', $credentials['email'])->first();
        if (Hash::check($credentials['password'], $account->password)) {
            return $account;
        }
        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // Verify the user with the username password in $ credentials, return `true` or `false`
        // if (Hash::check($user->getAuthPassword(), $credentials['password'])) {
        //     return true;
        // }
        return $user;
    }
}