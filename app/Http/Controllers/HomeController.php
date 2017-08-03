<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Korders;
use App\Ptitles;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{

    public function index($message = null)
    {
        session('url.intended', session('url.intended'));

        if (\Auth::check()) {
            $user = \Auth::user();

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
