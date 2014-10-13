<?php

class HomeController extends BaseController
{

    public function showDashboard()
    {
        if ( Auth::check() ) {
            return View::make( 'dashboard', [ 'greeting' => User::getGreeting(Auth::user()) ] );
        } else {
            return Redirect::intended( '/' );
        }
    }

    public function showWelcome()
    {
        return View::make( 'welcome' );
    }

}
