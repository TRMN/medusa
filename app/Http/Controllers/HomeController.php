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
        if (Auth::check()) {
            $user = Auth::user();

            $user->leftRibbonCount = count($user->getRibbons('L'));
            $user->leftRibbons = $user->getRibbons('L');

            $viewData = [
                'greeting' => $user->getGreetingArray(),
                'user'     => $user,
                'chapter'  => Chapter::find($user->getPrimaryAssignmentId()),
                'message'  => $message,
            ];

            $titles[''] = 'Select Peerage Title';

            foreach (Ptitles::orderBy('precedence')->get() as $title) {
                $titles[$title->title] = $title->title;
            }

            $orders[''] = 'Select Order';

            foreach (Korders::all() as $order) {
                $orders[$order->id] = $order->order;
            }

            $viewData['ptitles'] = $titles;
            $viewData['korders'] = $orders;

            if (empty($user->osa) === true) {
                return view('osa', array_merge($viewData, ['showform' => true]));
            } elseif ($user->tos === true) {
                return view('home', $viewData);
            }
            return view('terms', $viewData);
        } else {
            return view('login');
        }
    }

    public function osa()
    {
        return view('osa', ['showform' => false]);
    }
}
