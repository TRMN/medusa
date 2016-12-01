<?php
use Jenssegers\Mongodb\Model as Eloquent;

class OauthClient extends Eloquent
{
    protected $fillable = ['client_id', 'client_secret', 'redirect_url', 'client_name'];

    protected $table = 'oauth_clients';

    public static $rules = [
        'client_id'     => 'required|unique:oauth_clients',
        'redirect_url'  => 'url',
        'client_name'   => 'required',
    ];

        public static $updateRules = [
        'client_id'     => 'required',
        'redirect_url'  => 'url',
        'client_name'   => 'required',
    ];

}