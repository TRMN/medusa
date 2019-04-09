<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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
                'issuer'                 => 'https://medusa.trmn.org',
                'authorization_endpoint' => 'https://medusa.trmn.org/oauth/authorize',
                'token_endpoint'         => 'https://medusa.trmn.org/oauth/token',
                'userinfo_endpoint'      => 'https://medusa.trmn.org/oauth/profile',
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
        'middleware' => 'auth',
    ]
);
Route::post('/user/{user}/points', 'UserController@updatePoints')
     ->name('user.points')->middleware('auth');

Route::get(
    '/users/{branch}',
    [
    'middleware' => 'auth',
    ]
);
Route::get(
    '/user/rack/{user?}',
    [
    'middleware' => 'auth',
    ]
);
Route::post(
    '/user/rack/save/{user}',
    [
    'middleware' => 'auth',
    ]
);

Route::get(
    '/user/{user}/ribbons',
    [
    'middleware' => 'auth',
    ]
);

Route::post('/users/list/{branch}', 'UserController@getUserList');

Route::resource('user', 'UserController', ['middleware' => 'auth']);

Route::get(
    '/user/{user}/approve',
    [
        'middleware' => 'auth',
    ]
);
Route::get(
    '/user/{user}/deny',
    [
        'middleware' => 'auth',
    ]
);
Route::get(
    '/user/{user}/reset',
    [
    'middleware' => 'auth',
    ]
);
Route::post(
    '/user/{user}/reset',
    [
    'middleware' => 'auth',
    ]
);

// Assignment Change Requests
Route::model('request', \App\ChangeRequest::class);
Route::get(
    '/user_request/{user}/create',
    [
        'middleware' => 'auth',
    ]
);
Route::post(
    '/user_request',
    [
        'middleware' => 'auth',
    ]
);
Route::get(
    '/user_request/review',
    [
        'middleware' => 'auth',
    ]
);
Route::get(
    '/user_request/approve/{request}',
    [
        'middleware' => 'auth',
    ]
);
Route::get(
    '/user_request/deny/{request}',
    [
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
    '/home/{message?}', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('root');
Route::get('/login', 'HomeController@index')->name('login');
Route::get(
    '/chapter/{chapter}/decommission',
    [
        'middleware' => 'auth',
    ]
);
Route::post('/chapter/{chapter}/getRoster', 'ChapterController@getChapterMembers')
    ->middleware(['auth']);
Route::resource('chapter', 'ChapterController', ['middleware' => 'auth']);
Route::get(
    '/triadreport',
    [
        'middleware' => 'auth',
    ]
);
Route::get(
    '/export/{chapter}',
    [
        'middleware' => 'auth',
    ]
);

Route::resource('report', 'ReportController', ['middleware' => 'auth']);

Route::get(
    '/report/getexams/{id}',
    [
        'middleware' => 'auth',
    ]
);
Route::get(
    '/report/send/{id}',
    [
    'middleware' => 'auth',
    ]
);

Route::get(
    '/echelon/{echelon}/deactivate',
    [
        'middleware' => 'auth',
    ]
);
Route::resource('echelon', 'EchelonController', ['middleware' => 'auth']);

Route::model('unit', \App\Chapter::class);
Route::get(
    '/unit/{unit}/deactivate',
    [
        'middleware' => 'auth',
    ]
);

Route::resource('unit', 'UnitController', ['middleware' => 'auth']);
Route::resource('mardet', 'MardetController', ['middleware' => 'auth']);
Route::get(
    '/mardet/{unit}/deactivate',
    [
        'middleware' => 'auth',
    ]
);
Route::resource('anyunit', 'AnyUnitController', ['middleware' => 'auth']);
Route::get(
    '/anyunit/{unit}/deactivate',
    [
        'middleware' => 'auth',
    ]
);

Route::model('type', \App\Type::class);
Route::resource('type', 'TypeController', ['middleware' => 'auth']);

Route::get(
    '/exam',
    [
        'middleware' => 'auth',
    ]
);
Route::post(
    '/exam/upload',
    [
    'middleware' => 'auth',
    ]
);
Route::post(
    '/exam/update',
    [
    'middleware' => 'auth',
    ]
);
Route::get(
    '/exam/find/{user?}/{message?}',
    [ 'middleware' => 'auth']
);

Route::post(
    '/exam/store',
    [
        'middleware' => 'auth',
    ]
);
Route::get(
    '/exam/list',
    [
    'middleware' => 'auth',
    ]
);
Route::get(
    '/exam/create',
    [
    'middleware' => 'auth',
    ]
);

Route::model('exam', \App\ExamList::class);
Route::get(
    '/exam/edit/{exam}',
    [ 'middleware' => 'auth']
);
Route::post(
    '/exam/updateExam',
    [
    'middleware' => 'auth',
    ]
);
Route::post(
    '/exam/user/delete', 'ExamController@delete')->name('exam.deleteUserExam');

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
    'middleware' => 'auth',
    ]
);

Route::model('config', \App\MedusaConfig::class);
Route::resource('config', 'ConfigController', ['middleware' => 'auth']);

// Promotion routes

Route::get('/chapter/{chapter}/promotions', 'PromotionController@index')
     ->middleware('auth')->name('promotions');
Route::post('/bulkpromote', 'PromotionController@promote')->middleware('auth');

// Import routes

AdvancedRoute::controller('/upload', 'UploadController');
AdvancedRoute::controller('/download', 'DownloadController');

// API calls

Route::get(
    '/api/branch',
    'ApiController@getBranchList'
); // Get a list of all the tRMN branches
Route::get(
    '/api/country',
    'ApiController@getCountries'
); // Get a list of Countries and Country Codes
Route::get(
    '/api/branch/{branchID}/grade',
    'ApiController@getGradesForBranch'
); // Get a list of pay grades for that branch
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

Route::post('/api/path', 'ApiController@setPath', ['middleware' => 'auth']);

Route::get(
    '/api/find/{query?}',
    [
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
    '/api/findchapter/{query?}', 'ApiController@findChapter')->name('chapter.find.api');
Route::get(
    '/api/ribbonrack/{memberid}', 'ApiController@getRibbonRack')->name('ribbonrack');

Route::get('/api/chapterselection', 'ApiController@getChapterSelections');

// Update award display order
Route::post('/api/awards/updateOrder', 'ApiController@updateAwardDisplayOrder');

Route::post(
    '/api/rankcheck',
    ['uses' => 'ApiController@checkRankQual']
); //->middleware('auth');

Route::get('/api/awards/get_ribbon_image/{ribbonCode}/{ribbonCount}/{ribbonName}', 'ApiController@getRibbonImage');

Route::get('/api/lastexam/{memberid}', function ($memberid) {
    $exams = \App\Exam::where('member_id', '=', $memberid)->first();

    if (isset($exams) === true) {
        return $exams['updated_at'];
    } else {
        return false;
    }
});

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
        'middlware' => 'auth',
    ]
);

Route::any(
    '{catchall}',
    function ($url) {
        return response()->view('errors.404', [], 404);
    }
)->where('catchall', '(.*)');
