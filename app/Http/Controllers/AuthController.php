<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ForumUser;
use App\Models\Events\LoginComplete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        $rules = [
            'email'    => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make(Request::all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $email = Request::get('email');
        $password = Request::get('password');
        $redirect = Request::get('redirect_to');

        if (Auth::attempt([
            'email_address' => strtolower($email),
            'password' => $password,
            'active' => 1,
        ])) {
            User::find(Auth::user()->id)->updateLastLogin();

            event(new LoginComplete(Auth::user()));

            // Get last forum login
            if ($_SERVER['SERVER_NAME'] == 'medusa.trmn.org') {
                try {
                    $lastForumLogin = ForumUser::where('user_email', strtolower($email))
                        ->firstOrFail(['user_lastvisit'])
                        ->toArray();

                    Auth::user()->forum_last_login = $lastForumLogin['user_lastvisit'];
                } catch (Exception $e) {
                    Auth::user()->forum_last_login = false;
                }
            }

            Auth::user()->save();

            // Don't redirect back to the signin page
            if (basename($redirect) === 'signin') {
                $redirect = '/';
            }

            return Redirect::to($redirect);
        } else {
            return Redirect::back()
                ->with('message', 'Your username/password combination was incorrect')
                ->withInput();
        }
    }

    public function signout()
    {
        Auth::logout();
        Session::flush();

        return Redirect::intended('/');
    }

    private function redirectValid($redirect)
    {
        foreach (app()->router->getRoutes() as $route) {
            if (in_array('GET', $route->methods()) === true) {
                if (dirname($redirect) === dirname($route->uri)) {
                    return true;
                }
            }
        }

        return false;
    }
}
