<?php

class AuthController extends BaseController
{
    public function doSignin()
    {
        $email = Input::get( 'email' );
        $password = Input::get( 'password' );
        if ( Auth::attempt( [ 'email' => $email, 'password' => $password ] ) ) {
            return json_encode( [ 'status' => 'success' ] );
        } else {
            return json_encode( [ 'status' => 'error' ] );
        }
    }

    public function doSignout()
    {
        Auth::logout();

        return Redirect::intended( '/' );
    }
}