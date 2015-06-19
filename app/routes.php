<?php

$protocol = ( Request::secure() ) ? "https:" : "http:";

$host = Request::server( 'HTTP_HOST' );

$hostFull = $protocol . "//" . $host;

if ( Auth::check() ) {
    $authUser = Auth::getUser();
} else {
    $authUser = false;
}

View::share( 'serverUrl', $hostFull );
View::share( 'authUser', $authUser );

// Authentication

Route::get( '/signout', [ 'as' => 'signout', 'uses' => 'AuthController@signout' ] );
Route::post( '/signin', [ 'as' => 'signin', 'uses' => 'AuthController@signin' ] );
Route::get( '/register', [ 'as' => 'register', 'uses' => 'UserController@register' ] );
Route::post( '/apply', [ 'as' => 'user.apply', 'uses' => 'UserController@apply' ] );

// Users

Route::model( 'user', 'User' );
Route::get( '/user/{user}/confirmdelete', [ 'as' => 'user.confirmdelete', 'uses' => 'UserController@confirmDelete' ] );
Route::resource( 'user', 'UserController' );

// Other Routes

Route::get( '/home', [ 'as' => 'home', 'uses' => 'HomeController@index' ] );
Route::get( '/', [ 'as' => 'login', 'uses' => 'HomeController@index' ] );
Route::get('/login', ['as' => 'login', 'uses' => 'HomeController@index']);
Route::resource( 'chapter', 'ChapterController' );
Route::resource( 'announcement', 'AnnouncementController' );
Route::resource( 'report', 'ReportController' );

// API calls

Route::get( '/api/branch', 'ApiController@getBranchList' ); // Get a list of all the tRMN branches
Route::get( '/api/country', 'ApiController@getCountries' ); // Get a list of Countries and Country Codes
Route::get( '/api/branch/{branchID}/grade', 'ApiController@getGradesForBranch' ); // Get a list of pay grades for that branch
Route::get( '/api/chapter', 'ApiController@getChapters' ); // Get a list of all the chapters
Route::get( '/api/chapter/{branchID}', 'ApiController@getChaptersByBranch');
Route::get( '/api/branch/{branchID}/rate', 'ApiController@getRatingsForBranch' ); // Get a list of all the ratings
Route::post('/api/photo', 'ApiController@savePhoto'); // File Photo upload
