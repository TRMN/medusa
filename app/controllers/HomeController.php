<?php

class HomeController extends BaseController
{

    public function showDashboard()
    {
        if ( Auth::check() ) {
            $user = Auth::user();

            return View::make( 'dashboard', [ 'greeting' => $user->getGreeting(), 'user' => $user, 'chapter' => Chapter::find($user->getPrimaryAssignmentId()) ] );
        } else {
            return Redirect::intended( '/' );
        }
    }

    public function showWelcome()
    {
        return View::make( 'welcome' );
    }

}
