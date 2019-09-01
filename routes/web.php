<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

$request = Request::capture();

$protocol = ($request->secure()) ? 'https:' : 'http:';

$host = $request->server('HTTP_HOST');

$hostFull = $protocol.'//'.$host;

if (Auth::check()) {
    $authUser = Auth::user();
} else {
    $authUser = null;
}

View::share('serverUrl', $hostFull);
View::share('authUser', $authUser);

Auth::routes();

Route::get('/osa', 'HomeController@osa')->name('osa')->middleware('auth');
Route::get('/tos', 'HomeController@tos')->name('tos.noauth')->middleware('guest');

// OAuth2 routes

Route::post('/oauth/updateuser', 'OAuthController@updateUser')
     ->middleware('auth:api');
Route::get('/oauth/profile', 'OAuthController@profile')->middleware('auth:api');
Route::get('oauth/user', 'OAuthController@user')->middleware('auth:api');
Route::get('oauth/lastupdate', 'OAuthController@lastUpdated')
     ->middleware('auth:api');
Route::get('oauth/tistig', 'OAuthController@getTisTig')->middleware('auth:api');
Route::get('oauth/idcard', 'OAuthController@getIdCard')->middleware('auth:api');
Route::get('oauth/events', 'OAuthController@getScheduledEvents')
     ->middleware('auth:api');
Route::get('oauth/checkin', 'OAuthController@checkMemberIn')->middleware('auth:api');
Route::get(
    '/.well-known/openid-configuration',
    function () {
        return response()->json(
            \App\MedusaConfig::get(
                'openid-configuration',
                [
                'issuer'                 => secure_url("/"),
                'authorization_endpoint' => secure_url("/") . '/oauth/authorize',
                'token_endpoint'         => secure_url("/") . '/oauth/token',
                'userinfo_endpoint'      => secure_url("/") . '/oauth/profile',
                ]
            )
        );
    }
);

Route::model('oauthclient', \App\OAuthClient::class);
Route::resource('oauthclient', 'OAuthController', ['middleware' => 'auth']);

// Authentication
Route::get('/signout', 'AuthController@signout')->name('signout');
Route::post('/signin', 'AuthController@signin')->name('signin');
Route::get('/signin', 'HomeController@index')->middleware('guest');
Route::get('/register', 'UserController@register')->name('register')
     ->middleware('guest');
Route::post('/apply', 'UserController@apply')->name('user.apply')
     ->middleware('guest');

// Users
Route::model('user', \App\User::class);
Route::get('/user/switch/start/{user}', 'UserController@userSwitchStart')
     ->name('switch.start')->middleware('auth');
Route::get('/user/switch/stop/', 'UserController@userSwitchStop')
     ->name('switch.stop')->middleware('auth');
Route::get(
    '/user/finddups/{billet2check}',
    'UserController@findDuplicateAssignment'
)->name('user.dups')
     ->middleware('auth');
Route::get('/user/find/{user?}', 'UserController@find')->name('user.find')
     ->middleware('auth');
Route::get('/user/review', 'UserController@reviewApplications')->name('user.review')
     ->middleware('auth');
Route::get(
    '/user/{user}/confirmdelete',
    'UserController@confirmDelete'
)->name('user.confirmdelete')
     ->middleware('auth');
Route::post('/user/tos', 'UserController@tos')->name('tos')->middleware('auth');
Route::post('/user/osa', 'UserController@osa')->name('osa')->middleware('auth');
Route::post('/user/{user}/peerage', 'UserController@addOrEditPeerage')
     ->name('addOrEditPeerage')->middleware('auth');
Route::get(
    '/user/{user}/peerage/{peerageId}',
    'UserController@deletePeerage'
)->name('delete_peerage')
     ->middleware('auth');
Route::post('/user/{user}/note', 'UserController@addOrEditNote')
     ->name('addOrEditNote')->middleware('auth');
Route::get('/user/{user}/perm/{perm}/add', 'UserController@addPerm')
     ->name('user.perm.add')->middleware('auth');
Route::get(
    '/user/{user}/perm/{perm}/delete',
    [
        'as'         => 'user.perm.del',
        'uses'       => 'UserController@deletePerm',
        'middleware' => 'auth',
    ]
);
Route::post('/user/{user}/points', 'UserController@updatePoints')
     ->name('user.points')->middleware('auth');

Route::get(
    '/users/{branch}',
    [
    'as'         => 'showBranch',
    'uses'       => 'UserController@showBranch',
    'middleware' => 'auth',
    ]
);
Route::get(
    '/user/rack/{user?}',
    [
    'as'         => 'ribbonRack',
    'uses'       => 'UserController@buildRibbonRack',
    'middleware' => 'auth',
    ]
);
Route::post(
    '/user/rack/save/{user}',
    [
    'as'         => 'saverack',
    'uses'       => 'UserController@saveRibbonRack',
    'middleware' => 'auth',
    ]
);

Route::get(
    '/user/{user}/ribbons',
    [
    'as'         => 'userRibbons',
    'uses'       => 'UserController@fullRibbonDisplay',
    'middleware' => 'auth',
    ]
);

Route::post('/users/list/{branch}', 'UserController@getUserList');

Route::resource('user', 'UserController', ['middleware' => 'auth']);

Route::get(
    '/user/{user}/approve',
    [
        'as'         => 'user.approve',
        'uses'       => 'UserController@approveApplication',
        'middleware' => 'auth',
    ]
);
Route::get(
    '/user/{user}/deny',
    [
        'as'         => 'user.deny',
        'uses'       => 'UserController@denyApplication',
        'middleware' => 'auth',
    ]
);
Route::get(
    '/user/{user}/reset',
    [
    'as'         => 'user.getReset',
    'uses'       => 'UserController@getReset',
    'middleware' => 'auth',
    ]
);
Route::post(
    '/user/{user}/reset',
    [
    'as'         => 'user.postReset',
    'uses'       => 'UserController@postReset',
    'middleware' => 'auth',
    ]
);

// Assignment Change Requests
Route::model('request', \App\ChangeRequest::class);
Route::get(
    '/user_request/{user}/create',
    [
        'as'         => 'user.change.request',
        'uses'       => 'UserChangeRequestController@create',
        'middleware' => 'auth',
    ]
);
Route::post(
    '/user_request',
    [
        'as'         => 'user.change.store',
        'uses'       => 'UserChangeRequestController@store',
        'middleware' => 'auth',
    ]
);
Route::get(
    '/user_request/review',
    [
        'as'         => 'user.change.review',
        'uses'       => 'UserChangeRequestController@review',
        'middleware' => 'auth',
    ]
);
Route::get(
    '/user_request/approve/{request}',
    [
        'as'         => 'user.change.approve',
        'uses'       => 'UserChangeRequestController@approve',
        'middleware' => 'auth',
    ]
);
Route::get(
    '/user_request/deny/{request}',
    [
        'as'         => 'user.change.deny',
        'uses'       => 'UserChangeRequestController@deny',
        'middleware' => 'auth',
    ]
);

// Other Routes
Route::model('chapter', \App\Chapter::class);
Route::model('echelon', \App\Chapter::class);
Route::model('mardet', \App\Chapter::class);
Route::model('unit', \App\Chapter::class);
Route::model('anyunit', \App\Chapter::class);

Route::get(
    '/home/{message?}',
    ['as' => 'home', 'uses' => 'HomeController@index']
);
Route::get('/', ['as' => 'root', 'uses' => 'HomeController@index']);
Route::get('/login', ['as' => 'login', 'uses' => 'HomeController@index']);
Route::get(
    '/chapter/{chapter}/decommission',
    [
        'as'         => 'chapter.decommission',
        'uses'       => 'ChapterController@decommission',
        'middleware' => 'auth',
    ]
);
Route::post('/chapter/{chapter}/getRoster', 'ChapterController@getChapterMembers')
    ->middleware(['auth']);
Route::resource('chapter', 'ChapterController', ['middleware' => 'auth']);
Route::get(
    '/triadreport',
    [
        'as'         => 'chapter.triadreport',
        'uses'       => 'ChapterController@commandTriadReport',
        'middleware' => 'auth',
    ]
);
Route::get(
    '/export/{chapter}',
    [
        'as'         => 'roster.export',
        'uses'       => 'ChapterController@exportRoster',
        'middleware' => 'auth',
    ]
);

Route::resource('report', 'ReportController', ['middleware' => 'auth']);

Route::get(
    '/report/getexams/{id}',
    [
        'as'         => 'report.getexams',
        'uses'       => 'ReportController@getCompletedExamsForCrew',
        'middleware' => 'auth',
    ]
);
Route::get(
    '/report/send/{id}',
    [
    'as'         => 'report.send',
    'uses'       => 'ReportController@sendReport',
    'middleware' => 'auth',
    ]
);

Route::get(
    '/echelon/{echelon}/deactivate',
    [
        'as'         => 'echelon.deactivate',
        'uses'       => 'EchelonController@deactivate',
        'middleware' => 'auth',
    ]
);
Route::resource('echelon', 'EchelonController', ['middleware' => 'auth']);

Route::model('unit', \App\Chapter::class);
Route::get(
    '/unit/{unit}/deactivate',
    [
        'as'         => 'unit.deactivate',
        'uses'       => 'UnitController@deactivate',
        'middleware' => 'auth',
    ]
);

Route::resource('unit', 'UnitController', ['middleware' => 'auth']);
Route::resource('mardet', 'MardetController', ['middleware' => 'auth']);
Route::get(
    '/mardet/{unit}/deactivate',
    [
        'as'         => 'mardet.deactivate',
        'uses'       => 'MardetController@deactivate',
        'middleware' => 'auth',
    ]
);
Route::resource('anyunit', 'AnyUnitController', ['middleware' => 'auth']);
Route::get(
    '/anyunit/{unit}/deactivate',
    [
        'as'         => 'anyunit.deactivate',
        'uses'       => 'AnyUnitController@deactivate',
        'middleware' => 'auth',
    ]
);

Route::model('type', \App\Type::class);
Route::resource('type', 'TypeController', ['middleware' => 'auth']);

Route::get(
    '/exam',
    [
        'as'         => 'exam.index',
        'uses'       => 'ExamController@index',
        'middleware' => 'auth',
    ]
);
Route::post(
    '/exam/upload',
    [
    'as'         => 'exam.upload',
    'uses'       => 'ExamController@upload',
    'middleware' => 'auth',
    ]
);
Route::post(
    '/exam/update',
    [
    'as'         => 'exam.update',
    'uses'       => 'ExamController@update',
    'middleware' => 'auth',
    ]
);
Route::get(
    '/exam/find/{user?}/{message?}',
    ['as' => 'exam.find', 'uses' => 'ExamController@find', 'middleware' => 'auth']
);

Route::post(
    '/exam/store',
    [
        'as'         => 'exam.store',
        'uses'       => 'ExamController@store',
        'middleware' => 'auth',
    ]
);
Route::get(
    '/exam/list',
    [
    'as'         => 'exam.list',
    'uses'       => 'ExamController@examList',
    'middleware' => 'auth',
    ]
);
Route::get(
    '/exam/create',
    [
    'as'         => 'exam.create',
    'uses'       => 'ExamController@create',
    'middleware' => 'auth',
    ]
);

Route::model('exam', \App\ExamList::class);
Route::get(
    '/exam/edit/{exam}',
    ['as' => 'exam.edit', 'uses' => 'ExamController@edit', 'middleware' => 'auth']
);
Route::post(
    '/exam/updateExam',
    [
    'as'         => 'exam.updateExam',
    'uses'       => 'ExamController@updateExam',
    'middleware' => 'auth',
    ]
);
Route::post(
    '/exam/user/delete',
    ['as' => 'exam.deleteUserExam', 'uses' => 'ExamController@delete']
);

Route::model('billet', \App\Billet::class);
Route::resource('billet', 'BilletController', ['middleware' => 'auth']);

// Awards

Route::get('award', 'AwardController@index')->name('awards.index')
     ->middleware('auth');

// IdController
Route::get('id/qrcode/{id}', 'IdController@getQrcode');
Route::get('id/card/{id}', 'IdController@getCard');
Route::get('id/bulk/{id}', 'IdController@getBulk');
Route::get('id/markbulk/{id}', 'IdController@getMarkbulk');
Route::get('id/mark/{id}', 'IdController@getMark');

Route::model('events', \App\Events::class);
Route::resource('events', 'EventController', ['middleware' => 'auth']);
Route::get(
    '/events/export/{events}',
    [
    'as'         => 'event.export',
    'uses'       => 'EventController@export',
    'middleware' => 'auth',
    ]
);

Route::model('config', \App\MedusaConfig::class);
Route::resource('config', 'ConfigController', ['middleware' => 'auth']);

// Promotion routes

Route::get('/chapter/{chapter}/promotions', 'PromotionController@index')
     ->middleware('auth')->name('promotions');
Route::post('/bulkpromote', 'PromotionController@promote')->middleware('auth');

Route::get('/paygrades', 'PaygradeController@index')->middleware('auth')->name('paygrades');

// Import routes

AdvancedRoute::controller('/upload', 'UploadController');
AdvancedRoute::controller('/download', 'DownloadController');

// API calls

Route::get(
    '/api/branch',
    'ApiController@getBranchList'
); // Get a list of all the tRMN branches
Route::get('/api/branch/enhanced')->uses('ApiController@getEnhancedBranchList');
Route::get(
    '/api/country',
    'ApiController@getCountries'
); // Get a list of Countries and Country Codes
Route::get(
    '/api/branch/{branchID}/grade',
    'ApiController@getGradesForBranch'
); // Get a list of pay grades for that branch
Route::get('/api/branch/{branchID}/grade/unfiltered')->uses('ApiController@getUnfilteredPayGrades');

Route::get('/api/branch/{rating}/{branchID}', 'ApiController@getGradesForRating');
Route::get(
    '/api/chapter',
    'ApiController@getChapters'
); // Get a list of all the chapters
Route::get(
    '/api/chapter/{branchID}/{location?}',
    'ApiController@getChaptersByBranch'
);
Route::get('/api/locations', 'ApiController@getChapterLocations');
Route::get('/api/holding', 'ApiController@getHoldingChapters');
Route::get('/api/fleet', 'ApiController@getFleets');
Route::get('/api/hq', 'ApiController@getHeadquarters');
Route::get('/api/bureau', 'ApiController@getBureaus');
Route::get('/api/su', 'ApiController@getSeparationUnits');
Route::get('/api/tf', 'ApiController@getTaskForces');
Route::get('/api/tg', 'ApiController@getTaskGroups');
Route::get('/api/squadron', 'ApiController@getSquadrons');
Route::get('/api/division', 'ApiController@getDivisions');
Route::get('/api/office', 'ApiController@getOffices');
Route::get('/api/academy', 'ApiController@getAcademies');
Route::get('/api/college', 'ApiController@getColleges');
Route::get('/api/center', 'ApiController@getCenters');
Route::get('/api/institute', 'ApiController@getInstitutes');
Route::get('/api/university', 'ApiController@getUniversities');
Route::get(
    '/api/branch/{branchID}/rate',
    'ApiController@getRatingsForBranch'
); // Get a list of all the ratings
Route::get(
    '/api/korder/{orderid}',
    'ApiController@getKnightClasses'
); // Get the classes for a Knightly Order
Route::post(
    '/api/photo',
    'ApiController@savePhoto',
    ['middleware' => 'auth']
); // File Photo upload
Route::post('/api/apply')->uses('UserController@apply')->name('mobile.apply')->middleware('guest');

Route::post('/api/path', 'ApiController@setPath', ['middleware' => 'auth']);

Route::get(
    '/api/find/{query?}',
    [
    'as'         => 'user.find.api',
    'uses'       => 'ApiController@findMember',
    'middleware' => 'auth',
    ]
); // search for a member
Route::get(
    '/api/exam',
    'ApiController@findExam',
    ['middleware' => 'auth']
); // search for an exam
Route::get(
    '/api/checkemail/{email}',
    'ApiController@checkAddress'
); // Check that an email address is available
Route::get(
    '/api/findchapter/{query?}',
    ['as' => 'chapter.find.api', 'uses' => 'ApiController@findChapter']
);
Route::get(
    '/api/ribbonrack/{memberid}',
    ['as' => 'ribbonrack', 'uses' => 'ApiController@getRibbonRack']
);

Route::get('/api/paygradesforuser/{memberid}', 'ApiController@getPayGradesForUser');
Route::get('/api/branchforuser/{memberid}', 'ApiController@getBranchForUser');
Route::get('/api/checktransferrank/{memberid}/{branch}', 'ApiController@checkTransferRank');
Route::get('/api/promotioninfo/{memberid}/{paygrade}', 'ApiController@getPromotableInfo');

Route::get('/api/chapterselection', 'ApiController@getChapterSelections');

// Update award display order
Route::post('/api/awards/updateOrder', 'ApiController@updateAwardDisplayOrder');

Route::post('/api/rankcheck')->uses('ApiController@checkRankQual')->middleware('auth');

Route::get('/api/awards/get_ribbon_image/{ribbonCode}/{ribbonCount}/{ribbonName}', 'ApiController@getRibbonImage');

Route::get('/api/lastexam/{memberid}', function ($memberid) {
    $exams = \App\Exam::where('member_id', '=', $memberid)->first();

    if (isset($exams) === true) {
        return $exams['updated_at'];
    } else {
        return false;
    }
});

Route::get('/api/rank/transfer/{user}/{old}/{new}')->uses('ApiController@getNewRank')->middleware('auth');

Route::get(
    '/getRoutes',
    function () {
        foreach (app()->router->getRoutes() as $route) {
            if (in_array('GET', $route->methods()) === true) {
                echo dirname($route->uri())."<br />\n";
            }
        }
    }
);

// These MUST be the last two routes
Route::get(
    '/user/{user}/{message?}',
    [
        'as'        => 'user.show',
        'uses'      => 'UserController@show',
        'middleware' => 'auth',
    ]
);

Route::any(
    '{catchall}',
    function ($url) {
        return response()->view('errors.404', [], 404);
    }
)->where('catchall', '(.*)');
