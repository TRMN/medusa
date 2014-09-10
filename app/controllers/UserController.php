<?php

class UserController extends BaseController {
    public function showUsers() {
        $users = User::all();

        return View::make( 'users', [ 
            'users' => $users,
            'pageTitle' => 'Users',
        ] );
    }

    public function showUser( $id ) {
        $user = User::find( $id );

        if ( $user ) {
            return View::make( 'user', [
                'profile' => $user,
                'pageTitle' => $user->name,
            ]);
        } else {
            App::abort( 404 );
        }
    }

    public function editUserForm( $id ) {
        $user = User::find( $id );

        if ( $user ) {
            return View::make( 'user-edit', [
                'profile' => $user,
                'pageTitle' => 'Editing ' . $user->name,
            ]);
        } else {
            App::abort( 404 );
        }
    }
}