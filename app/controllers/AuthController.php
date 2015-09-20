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

        if ( Auth::attempt(['email_address' => strtolower($email), 'password' => $password, 'active' => 1])) {
            return Redirect::route('home');
        } else {
            return Redirect::route('login')->with('message', 'Your username/password combination was incorrect')
                ->withInput();
        }


        return Redirect::route('login')->withErrors( $validator );
    }

    public function signout()
    {
        Auth::logout();
        Session::flush();

        return Redirect::intended( '/' );
    }
}
