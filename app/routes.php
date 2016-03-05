<?php

$protocol = ( Request::secure() ) ? "https:" : "http:";

$host = Request::server( 'HTTP_HOST' );

$hostFull = $protocol . "//" . $host;

if ( Auth::check() ) {
    $authUser = Auth::user();
} else {
    $authUser = null;
}

View::share( 'serverUrl', $hostFull );
View::share( 'authUser', $authUser );

// Authentication

Route::get( '/signout', [ 'as' => 'signout', 'uses' => 'AuthController@signout' ] );
Route::post( '/signin', [ 'as' => 'signin', 'uses' => 'AuthController@signin' ] );
Route::get( '/register', [ 'as' => 'register', 'uses' => 'UserController@register' ] );
Route::post( '/apply', [ 'as' => 'user.apply', 'uses' => 'UserController@apply' ] );


// Users

Route::model( 'user', 'User');
Route::get('/user/find/{billet2check}', ['as' => 'user.dups', 'uses' => 'UserController@findDuplicateAssignment']);
Route::get('/user/review', ['as' => 'user.review', 'uses' => 'UserController@reviewApplications', 'before' => 'auth']);
Route::get( '/user/{user}/confirmdelete', [ 'as' => 'user.confirmdelete', 'uses' => 'UserController@confirmDelete', 'before' => 'auth' ] );
Route::post('/user/tos', ['as' => 'tos', 'uses' => 'UserController@tos', 'before' => 'auth']);
Route::post('/user/osa', ['as' => 'osa', 'uses' => 'UserController@osa', 'before' => 'auth']);

Route::resource( 'user', 'UserController', ['before' => 'auth'] );
Route::get('/user/{user}/approve', ['as' => 'user.approve', 'uses' => 'UserController@approveApplication', 'before' => 'auth']);
Route::get(
    '/user/{user}/deny',
    ['as' => 'user.deny', 'uses' => 'UserController@denyApplication', 'before' => 'auth']
);
Route::get('/user/{user}/reset', ['as' => 'user.getReset', 'uses' => 'UserController@getReset', 'before' => 'auth']);
Route::post('/user/{user}/reset', ['as' => 'user.postReset', 'uses' => 'UserController@postReset', 'before' => 'auth']);


// Assignment Change Requests
Route::model('request', 'ChangeRequest');
Route::get('/user_request/{user}/create', ['as' => 'user.change.request', 'uses' => 'UserChangeRequestController@create', 'before' => 'auth']);
Route::post('/user_request', ['as' => 'user.change.store', 'uses' => 'UserChangeRequestController@store', 'before' => 'auth']);
Route::get('/user_request/review', ['as' => 'user.change.review', 'uses' => 'UserChangeRequestController@review', 'before' => 'auth']);
Route::get('/user_request/approve/{request}', ['as' => 'user.change.approve', 'uses' => 'UserChangeRequestController@approve', 'before' => 'auth']);
Route::get('/user_request/deny/{request}', ['as' => 'user.change.deny', 'uses' => 'UserChangeRequestController@deny', 'before' => 'auth']);

// Other Routes
Route::model('chapter', 'Chapter');
Route::model('echelon', 'Chapter');
Route::model('mardet', 'Chapter');
Route::model('unit', 'Chapter');
Route::model('anyunit', 'Chapter');

Route::get( '/home', [ 'as' => 'home', 'uses' => 'HomeController@index'] );
Route::get( '/', [ 'as' => 'root', 'uses' => 'HomeController@index' ] );
Route::get('/login', ['as' => 'login', 'uses' => 'HomeController@index']);
Route::get(
    '/chapter/{chapter}/decommission',
    ['as' => 'chapter.decommission', 'uses' => 'ChapterController@decommission', 'before' => 'auth']
);
Route::resource( 'chapter', 'ChapterController', ['before' => 'auth'] );
Route::get('/triadreport', ['as' => 'chapter.triadreport', 'uses' => 'ChapterController@commandTriadReport', 'before' => 'auth']);
Route::resource( 'announcement', 'AnnouncementController', ['before' => 'auth'] );
Route::resource( 'report', 'ReportController', ['before' => 'auth'] );

Route::get('/report/getexams/{id}', ['as' => 'report.getexams', 'uses' => 'ReportController@getCompletedExamsForCrew', 'before' => 'auth']);
Route::get('/report/send/{id}', ['as' => 'report.send', 'uses' => 'ReportController@sendReport', 'before' => 'auth']);

Route::get(
    '/echelon/{echelon}/deactivate',
    ['as' => 'echelon.deactivate', 'uses' => 'EchelonController@deactivate', 'before' => 'auth']
);
Route::resource('echelon', 'EchelonController', ['before' => 'auth']);

Route::model('unit', 'Chapter');
Route::get(
    '/unit/{unit}/deactivate',
    ['as' => 'unit.deactivate', 'uses' => 'UnitController@deactivate', 'before' => 'auth']
);

Route::resource('unit', 'UnitController', ['before' => 'auth']);
Route::resource('mardet', 'MardetController', ['before' => 'auth']);
Route::get(
    '/mardet/{unit}/deactivate',
    ['as' => 'mardet.deactivate', 'uses' => 'MardetController@deactivate', 'before' => 'auth']
);
Route::resource('anyunit', 'AnyUnitController', ['before' => 'auth']);
Route::get(
    '/anyunit/{unit}/deactivate',
    ['as' => 'anyunit.deactivate', 'uses' => 'AnyUnitController@deactivate', 'before' => 'auth']
);

Route::model('type', 'Type');
Route::resource('type', 'TypeController', ['before' => 'auth']);

Route::controller('password', 'RemindersController');

Route::get('/exam', ['as' => 'exam.index', 'uses' => 'ExamController@index', 'before' => 'auth']);
Route::post('/exam/upload', ['as' => 'exam.upload', 'uses' => 'ExamController@upload', 'before' => 'auth']);

Route::model('billet', 'Billet');
Route::resource('billet', 'BilletController', ['before' => 'auth']);

// API calls

Route::get( '/api/branch', 'ApiController@getBranchList'); // Get a list of all the tRMN branches
Route::get( '/api/country', 'ApiController@getCountries'); // Get a list of Countries and Country Codes
Route::get( '/api/branch/{branchID}/grade', 'ApiController@getGradesForBranch'); // Get a list of pay grades for that branch
Route::get( '/api/chapter', 'ApiController@getChapters'); // Get a list of all the chapters
Route::get( '/api/chapter/{branchID}/{location}', 'ApiController@getChaptersByBranch');
Route::get( '/api/locations', 'ApiController@getChapterLocations');
Route::get( '/api/holding', 'ApiController@getHoldingChapters');
Route::get( '/api/fleet', 'ApiController@getFleets');
Route::get( '/api/hq', 'ApiController@getHeadquarters');
Route::get( '/api/bureau', 'ApiController@getBureaus');
Route::get( '/api/su', 'ApiController@getSeparationUnits');
Route::get( '/api/tf', 'ApiController@getTaskForces');
Route::get('/api/tg', 'ApiController@getTaskGroups');
Route::get('/api/squadron', 'ApiController@getSquadrons');
Route::get('/api/division', 'ApiController@getDivisions');
Route::get('/api/office', 'ApiController@getOffices');
Route::get('/api/academy', 'ApiController@getAcademies');
Route::get('/api/college', 'ApiController@getColleges');
Route::get('/api/center', 'ApiController@getCenters');
Route::get('/api/institute', 'ApiController@getInstitutes');
Route::get( '/api/branch/{branchID}/rate', 'ApiController@getRatingsForBranch'); // Get a list of all the ratings
Route::post('/api/photo', 'ApiController@savePhoto', ['before' => 'auth']); // File Photo upload


