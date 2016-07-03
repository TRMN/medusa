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

// OAuth2
App::singleton('oauth2', function() {

    $storage = $storage = new OAuth2\Storage\Mongo(\DB::getMongoDB());
	$server = new OAuth2\Server($storage);

    $server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
	$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
	$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
    $server->addGrantType(new OAuth2\GrantType\RefreshToken($storage));

	return $server;
});

Route::get('oauth/authorize', function ()
{
	$bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
	$bridgedResponse = new OAuth2\HttpFoundationBridge\Response();

    App::make('oauth2')->validateAuthorizeRequest($bridgedRequest, $bridgedResponse);

    if (!$bridgedResponse) {
        return $bridgedResponse;
    }

    $params = $bridgedRequest->getAllQueryParameters();
    $client = OauthClient::where('client_id', '=', $params['client_id'])->first();

    return View::make('oauth.authorization-form', ['client' => $client, 'params' => $params, 'permsObj' => new \Medusa\Permissions\PermissionsHelper()]);
});

Route::post('oauth/authorize', function()
{
	$bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
	$bridgedResponse = new OAuth2\HttpFoundationBridge\Response();

    $is_authorized = ($bridgedRequest->get('authorized') === 'Approve');

    App::make('oauth2')->handleAuthorizeRequest($bridgedRequest, $bridgedResponse, $is_authorized, Auth::user()->id);

    return $bridgedResponse;
});

Route::post('oauth/token', function()
{
	$bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
	$bridgedResponse = new OAuth2\HttpFoundationBridge\Response();

	$bridgedResponse = App::make('oauth2')->handleTokenRequest($bridgedRequest, $bridgedResponse);

	return $bridgedResponse;
});

Route::get('oauth/profile', function()
{
	$bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
	$bridgedResponse = new OAuth2\HttpFoundationBridge\Response();

	if (App::make('oauth2')->verifyResourceRequest($bridgedRequest, $bridgedResponse)) {

		$token = App::make('oauth2')->getAccessTokenData($bridgedRequest);

        $user = User::find($token['user_id']);

		return Response::json(array(
			'uid' => $token['user_id'],
            'email' => $user->email_address,
            'firstname' => $user->first_name,
            'lastname' => $user->last_name,
            'city' => $user->city,
            'state_province' => $user->state_province,
            'country' => $user->country,
            'imageurl' => $user->filePhoto,
			'user_id' => $token['user_id'],
			'client'  => $token['client_id'],
			'expires' => $token['expires'],
		));
	}
	else {
		return Response::json(array(
			'error' => 'Unauthorized'
		), $bridgedResponse->getStatusCode());
	}
});

// Authentication

Route::get( '/signout', [ 'as' => 'signout', 'uses' => 'AuthController@signout' ] );
Route::post( '/signin', [ 'as' => 'signin', 'uses' => 'AuthController@signin' ] );
Route::get( '/register', [ 'as' => 'register', 'uses' => 'UserController@register' ] );
Route::post( '/apply', [ 'as' => 'user.apply', 'uses' => 'UserController@apply' ] );


// Users

Route::model( 'user', 'User');
Route::get('/user/finddups/{billet2check}', ['as' => 'user.dups', 'uses' => 'UserController@findDuplicateAssignment', 'before' => 'auth']);
Route::get('/user/find/{user?}', ['as' => 'user.find', 'uses'=> 'UserController@find', 'before' => 'auth']);
Route::get('/user/review', ['as' => 'user.review', 'uses' => 'UserController@reviewApplications', 'before' => 'auth']);
Route::get( '/user/{user}/confirmdelete', [ 'as' => 'user.confirmdelete', 'uses' => 'UserController@confirmDelete', 'before' => 'auth' ] );
Route::post('/user/tos', ['as' => 'tos', 'uses' => 'UserController@tos', 'before' => 'auth']);
Route::post('/user/osa', ['as' => 'osa', 'uses' => 'UserController@osa', 'before' => 'auth']);
Route::post('/user/{user}/peerage', ['as' => 'addOrEditPeerage', 'uses' => 'UserController@addOrEditPeerage', 'before' => 'auth']);
Route::get('/user/{user}/peerage/{peerageId}', ['as' => 'delete_peerage', 'uses' => 'UserController@deletePeerage', 'before' => 'auth']);
Route::post('/user/{user}/note', ['as' => 'addOrEditNote', 'uses' => 'UserController@addOrEditNote', 'before' => 'auth']);
Route::get('/user/{user}/perm/{perm}/add', ['as' => 'user.perm.add', 'uses' => 'UserController@addPerm', 'before' => 'auth']);
Route::get('/user/{user}/perm/{perm}/delete', ['as' => 'user.perm.del', 'uses' => 'UserController@deletePerm', 'before' => 'auth']);
Route::get('/users/{branch}', ['as' => 'showBranch', 'uses' => 'UserController@showBranch', 'before' => 'auth']);

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

Route::get( '/home/{message?}', [ 'as' => 'home', 'uses' => 'HomeController@index'] );
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
Route::post('/exam/update', ['as' => 'exam.update', 'uses' => 'ExamController@update', 'before' => 'auth']);
Route::get('/exam/find/{user?}/{message?}', ['as' => 'exam.find', 'uses' => 'ExamController@find', 'before' => 'auth']);
#Route::get('/exam/user/{user}', ['as' => 'exam.show', 'uses' => 'ExamController@showUser', 'before' => 'auth']);
Route::post('/exam/store', ['as' => 'exam.store', 'uses' => 'ExamController@store', 'before' => 'auth']);
Route::get('/exam/list', ['as' => 'exam.list', 'uses' => 'ExamController@examList', 'before' => 'auth']);
Route::get('/exam/create', ['as' => 'exam.create', 'uses' => 'ExamController@create', 'before' => 'auth']);

Route::model('exam', 'ExamList');
Route::get('/exam/edit/{exam}', ['as' => 'exam.edit', 'uses' => 'ExamController@edit', 'before' => 'auth']);
Route::post('/exam/updateExam', ['as' => 'exam.updateExam', 'uses' => 'ExamController@updateExam', 'before' => 'auth']);
Route::post('/exam/user/delete', ['as' => 'exam.deleteUserExam', 'uses' => 'ExamController@delete']);

Route::model('billet', 'Billet');
Route::resource('billet', 'BilletController', ['before' => 'auth']);

Route::controller('id', 'IdController', ['before' => 'auth']);

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
Route::get('/api/university', 'ApiController@getUniversities');
Route::get( '/api/branch/{branchID}/rate', 'ApiController@getRatingsForBranch'); // Get a list of all the ratings
Route::get( '/api/korder/{orderid}', 'ApiController@getKnightClasses'); // Get the classes for a Knightly Order
Route::post('/api/photo', 'ApiController@savePhoto', ['before' => 'auth']); // File Photo upload
Route::get(' /api/find', 'ApiController@findMember', ['before' => 'auth']); // search for a member
Route::get('/api/exam', 'ApiController@findExam', ['before' => 'auth']); // search for an exam


