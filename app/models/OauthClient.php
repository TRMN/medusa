<?php
use Jenssegers\Mongodb\Model as Eloquent;

class OauthClient extends Eloquent {
	protected $fillable = [ 'client_id', 'client_secret', 'redirect_url', 'client_name'];

    protected $table = 'oauth_clients';
}