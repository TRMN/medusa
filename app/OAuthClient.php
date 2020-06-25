<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OAuthClient extends Eloquent
{
    protected $fillable = ['client_id', 'secret', 'redirect', 'name', 'personal_access_client', 'password_client', 'revoked'];

    protected $table = 'oauth_clients';

    public static $rules = [
        'client_id' => 'required|unique:oauth_clients',
        'redirect' => 'url',
        'name' => 'required',
    ];

    public static $updateRules = [
        'client_id' => 'required',
        'redirect' => 'url',
        'name' => 'required',
    ];
}
