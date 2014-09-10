<?php

$protocol = ( Request::secure() ) ? "https:" : "http:";

$host = Request::server( 'HTTP_HOST' );

$hostFull = $protocol . "//" . $host;

View::share( 'serverUrl', $hostFull );

if ( Auth::check() ) {
    View::share( 'user', Auth::user() );
} else {
    View::share( 'user', false );
}

Route::get( '/signout', 'AuthController@doSignout' );
Route::post( '/signin', 'AuthController@doSignin' );
Route::get( '/dashboard', 'HomeController@showDashboard' );
Route::get( '/', 'HomeController@showWelcome' );

// Users

Route::model( 'user', 'User' );
Route::resource( 'user', 'UserController' );

/*
Route::get( '/user', [ 'as' => 'user.index', 'uses' => 'UsersController@index' ] );
Route::get( '/user/{user}', [ 'as' => 'user.view', 'uses' => 'UsersController@show' ] );
Route::get( '/user/{user}/edit', [ 'as' => 'user.edit', 'uses' => 'UsersController@edit' ] );
Route::get( '/user/create', [ 'as' => 'user.create', 'uses' => 'UsersController@create' ] );
Route::post( '/user/', [ 'as' => 'user.save', 'uses' => 'UsersController@store' ] );
Route::put( '/user/{user}', [ 'as' => 'user.update', 'uses' => 'UsersController@update' ] );
Route::delete( '/user/{user}', [ 'as' => 'user.delete', 'uses' => 'UsersController@destroy' ] );
*/