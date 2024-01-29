<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index($message = null)
    {
        session('url.intended', session('url.intended'));

        if (Auth::check()) {
            /** @var  \App\User $user */
            $user = Auth::user();
            if ($user->isRequiredToChangePwd()) {
                $path = '/user/' . $user->id . '/reset';
                $ssl_available = config('app.ssl_available');
                return redirect($path, 302, [], $ssl_available);
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
