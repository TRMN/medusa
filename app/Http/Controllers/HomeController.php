<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Korders;
use App\Ptitles;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index($message = null)
    {
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
}
