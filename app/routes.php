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

Route::get( '/signout', [ 'as' => 'signout', 'uses' => 'AuthController@signout', 'before' => 'auth' ] );
Route::post( '/signin', [ 'as' => 'signin', 'uses' => 'AuthController@signin' ] );
Route::get( '/register', [ 'as' => 'register', 'uses' => 'UserController@register' ] );
Route::post( '/apply', [ 'as' => 'user.apply', 'uses' => 'UserController@apply' ] );

// Users

Route::model( 'user', 'User');
Route::get( '/user/{user}/confirmdelete', [ 'as' => 'user.confirmdelete', 'uses' => 'UserController@confirmDelete', 'before' => 'auth' ] );
Route::get('/user/review', ['as' => 'user.review', 'uses' => 'UserController@reviewApplications', 'before' => 'auth']);
Route::resource( 'user', 'UserController', ['before' => 'auth'] );
Route::get('/user/{user}/approve', ['as' => 'user.approve', 'uses' => 'UserController@approveApplication', 'before' => 'auth']);
Route::get(
    '/user/{user}/deny',
    ['as' => 'user.deny', 'uses' => 'UserController@denyApplication', 'before' => 'auth']
);
Route::post('/user/tos', ['as' => 'tos', 'uses' => 'UserController@tos', 'before' => 'auth']);

// Assignment Change Requests
Route::get('/user_request/{user}/create', ['as' => 'user.change.request', 'uses' => 'UserChangeRequest@create', 'before' => 'auth']);
Route::post('/user_request', ['as' => 'user.change.store', 'uses' => 'UserChangeRequest@store', 'before' => 'auth']);
Route::get('/user_request/review', ['as' => 'user.change.review', 'uses' => 'UserChangeRequest@review', 'before' => 'auth']);

// Other Routes

Route::get( '/home', [ 'as' => 'home', 'uses' => 'HomeController@index', 'before' => 'auth' ] );
Route::get( '/', [ 'as' => 'login', 'uses' => 'HomeController@index' ] );
Route::get('/login', ['as' => 'login', 'uses' => 'HomeController@index']);
Route::resource( 'chapter', 'ChapterController', ['before' => 'auth'] );
Route::resource( 'announcement', 'AnnouncementController', ['before' => 'auth'] );
Route::resource( 'report', 'ReportController', ['before' => 'auth'] );

// API calls

Route::get( '/api/branch', 'ApiController@getBranchList', ['before' => 'auth'] ); // Get a list of all the tRMN branches
Route::get( '/api/country', 'ApiController@getCountries', ['before' => 'auth'] ); // Get a list of Countries and Country Codes
Route::get( '/api/branch/{branchID}/grade', 'ApiController@getGradesForBranch', ['before' => 'auth'] ); // Get a list of pay grades for that branch
Route::get( '/api/chapter', 'ApiController@getChapters', ['before' => 'auth'] ); // Get a list of all the chapters
Route::get( '/api/chapter/{branchID}/{location}', 'ApiController@getChaptersByBranch', ['before' => 'auth']);
Route::get( '/api/locations', 'ApiController@getChapterLocations');
Route::get( '/api/holding', 'ApiController@getHoldingChapters');
Route::get( '/api/fleet', 'ApiController@getFleets');
Route::get( '/api/hq', 'ApiController@getHeadquarters');
Route::get( '/api/bureau', 'ApiController@getBureaus');
Route::get( '/api/su', 'ApiController@getSeparationUnits');
Route::get( '/api/branch/{branchID}/rate', 'ApiController@getRatingsForBranch', ['before' => 'auth'] ); // Get a list of all the ratings
Route::post('/api/photo', 'ApiController@savePhoto', ['before' => 'auth']); // File Photo upload
Route::get('/api/mtest', 'ApiController@testMongo');
