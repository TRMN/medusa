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
Route::get( '/user/{user}/confirmdelete', 'UserController@confirmDelete' );
Route::resource( 'user', 'UserController' );
Route::resource( 'chapter', 'ChapterController' );

// API calls

Route::get('/api/branch', 'ApiController@getBranchList'); // Get a list of all the tRMN branches
Route::get('/api/country', 'ApiController@getCountries'); // Get a list of Countries and Country Codes
Route::get('/api/branch/{branchID}/grade', 'ApiController@getGradesForBranch'); // Get a list of pay grades for that branch
Route::get('/api/chapter', 'ApiController@getChapters'); // Get a list of all the chapters
Route::get('/api/branch/{branchID}/rate', 'ApiController@getRatingsForBranch'); // Get a list of all the ratings
