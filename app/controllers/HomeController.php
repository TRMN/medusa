<?php

class HomeController extends BaseController
{

    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            $viewData = [
                'greeting' => $user->getGreetingArray(),
                'user'     => $user,
                'chapter'  => Chapter::find($user->getPrimaryAssignmentId()),
            ];

            $titles[''] = 'Select Peerage Title';

            foreach(Ptitles::orderBy('precedence')->get() as $title) {
                $titles[$title->title] = $title->title;
            }

            $orders[''] = 'Select Order';

            foreach(Korders::all() as $order) {
                $orders[$order->id] = $order->order;
            }

            $viewData['ptitles'] = $titles;
            $viewData['korders'] = $orders;

            if (empty( $user->osa ) === true) {
                return View::make('osa', $viewData);
            } elseif ($user->tos === true) {
                return View::make('home', $viewData);
            }
            return View::make('terms', $viewData);
        } else {
            return View::make('login');
        }
    }
}
