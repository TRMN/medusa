<?php

class AuthController extends BaseController
{
    public function doSignin()
    {
        $email = Input::get( 'email' );
        $password = Input::get( 'password' );

        if ( Auth::attempt( [ 'email_address' => $email, 'password' => $password ] ) ) {
            $response = Response::make( json_encode( [ 'status' => 'success' ] ) );
        } else {
            $response = Response::make( json_encode( [ 'status' => 'error' ] ) );
        }

        return $response;
    }

    public function doSignout()
    {
        Auth::logout();

        return Redirect::intended( '/' );
    }
}