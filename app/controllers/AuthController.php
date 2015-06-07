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

        $pwd_check = User::where( 'email_address', '=', $email )->where( 'password', '=', sha1( $password ) )->get();

        if ( count( $pwd_check) > 0 ) {
            Auth::login($pwd_check[0]);
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
