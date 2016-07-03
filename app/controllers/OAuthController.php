<?php

use Illuminate\Routing\Controller;
use LucaDegasperi\OAuth2Server\Authorizer;

class OAuthController extends BaseController
{
    protected $authorizer;

    public function __construct(Authorizer $authorizer)
    {

        $this->authorizer = $authorizer;

        $this->beforeFilter('auth', ['only' => ['getAuthorize', 'postAuthorize']]);
        $this->beforeFilter('csrf', ['only' => 'postAuthorize']);
        $this->beforeFilter('check-authorization-params', ['only' => ['getAuthorize', 'postAuthorize']]);

        parent::__construct();
    }

    public function postAccessToken()
    {
        return Response::json($this->authorizer->issueAccessToken());
    }

    public function getAuthorize()
    {
        $authParams = $this->authorizer->getAuthCodeRequestParams();

        $formParams = array_except($authParams, 'client');

        $formParams['client_id'] = $authParams['client']->getId();

        $formParams['scope'] = implode(
            config('oauth2.scope_delimiter'),
            array_map(
                function ($scope) {
                    return $scope->getId();
                },
                $authParams['scopes']
            )
        );


        return View::make('oauth.authorization-form', ['params' => $formParams, 'client' => $authParams['client']]);
    }

    public function postAuthorize()
    {
        $params = $this->authorizer->getAuthCodeRequestParams();
        $params['user_id'] = Auth::user()->id;
        $redirectUri = '/';

        // If the user has allowed the client to access its data, redirect back to the client with an auth code.
        if (Request::has('approve')) {
            $redirectUri = $this->authorizer->issueAuthCode('user', $params['user_id'], $params);
        }

        // If the user has denied the client to access its data, redirect back to the client with an error message.
        if (Request::has('deny')) {
            $redirectUri = $this->authorizer->authCodeRequestDeniedRedirectUri();
        }

        return Redirect::to($redirectUri);
    }
}
