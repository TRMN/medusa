<?php

class AuthController extends Controller
{
    public function signin()
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $email = Input::get('email');
        $password = Input::get('password');

        if (Auth::attempt(['email_address' => strtolower($email), 'password' => $password, 'active' => 1])) {
            User::find(Auth::user()->id)->updateLastLogin();
            return Redirect::back();
        } else {
            return Redirect::back()->with('message', 'Your username/password combination was incorrect')
                ->withInput();
        }
    }

    public function signout()
    {
        Auth::logout();
        Session::flush();

        return Redirect::intended('/');
    }
}
