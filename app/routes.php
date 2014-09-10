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

// Ranks

Route::get( '/ranks', 'RankController@showRanks' );
Route::get( '/ranks/add', 'RankController@addRankForm' );
Route::post( '/ranks/', 'RankController@addRank' );
Route::put( '/ranks/{id}', 'RankController@saveRank' );
Route::delete( '/ranks/{id}/delete', 'RankController@deleteRank' );

// Ships

Route::get( '/ships', 'ShipController@showShips' );
Route::get( '/ships/{shipname}', 'ShipController@showShip' );

// Users

Route::get( '/users', 'UserController@showUsers' );
Route::get( '/users/{id}', 'UserController@showUser' );
Route::get( '/users/{id}/edit', 'UserController@editUserForm' );
Route::get( '/users/add', 'UserController@addUserForm' );
Route::post( '/users/', 'UserController@addUser' );
Route::put( '/users/{id}', 'UserController@saveUser' );
Route::delete( '/users/{id}', 'UserController@deleteUser' );