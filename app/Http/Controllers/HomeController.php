<?php

namespace App\Http\Controllers;

use Config;

class HomeController extends Controller
{
    public function index($message = null)
    {
        session('url.intended', session('url.intended'));

        if (\Auth::check()) {
            $user = \Auth::user();
            $pwd_age = $user->getPwdAge();
            if ($user->isRequiredToChangePwd()) {
                return redirect()->secure('/user/' . $user->id . '/reset');
            }

            if (empty($user->osa) === true) {
                return view('osa', ['showform' => true, 'greeting' => $user->getGreetingArray()]);
            } elseif ($user->tos === true) {
                return redirect()->route('user.show', ['user' => $user->id, 'message' => $message]);
            }

            return view('terms');
        } else {
            return view('login');
        }
    }

    public function osa()
    {
        return view('osa', ['showform' => false]);
    }

    public function tos()
    {
        return view('tos');
    }
}
