<?php

$protocol = ( Request::secure() ) ? "https:" : "http:";

$host = Request::server( 'HTTP_HOST' );

$hostFull = $protocol . "//" . $host;

View::share( 'serverUrl', $hostFull );

if ( Auth::check() ) {
    View::share( 'authUser', Auth::user() );
} else {
    View::share( 'authUser', false );
}

Route::get( '/signout', 'AuthController@doSignout' );
Route::post( '/signin', 'AuthController@doSignin' );
Route::get( '/dashboard', 'HomeController@showDashboard' );
Route::get( '/', 'HomeController@showWelcome' );

// Users

Route::model( 'user', 'User' );
Route::get( '/user/{user}/confirmdelete', [ 'as' => 'user.confirmdelete', 'uses' => 'UserController@confirmDelete' ] );
Route::resource( 'user', 'UserController' );
Route::resource( 'ship', 'ShipController' );