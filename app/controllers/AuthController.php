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
            return Redirect::route('login')->withErrors( $validator );
        }

        $email = Input::get( 'email' );
        $password = Input::get( 'password' );

        if ( Auth::attempt(['email_address' => $email, 'password' => $password, 'active' => 1])) {
            return Redirect::route('home');
        }


        return Redirect::route('login')->withErrors( $validator );
    }

    public function signout()
    {
        Auth::logout();

        return Redirect::intended( '/' );
    }
}
