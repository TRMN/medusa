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

            if ($user->tos === true) {
                return View::make('home', $viewData);
            }
            return View::make('terms', $viewData);
        } else {
            return View::make('login');
        }
    }
}
