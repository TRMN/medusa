<?php

class AuthController extends BaseController
{
    public function signin()
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make( Input::all(), $rules );

        if ( $validator->fails() )
        {
            return Redirect::route( 'home' )->withErrors( $validator );
        }

        $email = Input::get( 'email' );
        $password = Input::get( 'password' );

        if ( Auth::attempt(['email_address' => $email, 'password' => $password, 'active' => 1])) {
            return Redirect::route( 'dashboard' );
        }


        return Redirect::route( 'home' )->withErrors( $validator );
    }

    public function signout()
    {
        Auth::logout();

        return Redirect::intended( '/' );
    }
}
