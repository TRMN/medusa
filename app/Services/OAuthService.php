<?php

namespace App\Services;

use App\Audit\MedusaAudit;
use App\ExamList;
use App\Korders;
use App\Oauth\Storage\MedusaUserCredentials;
use App\OauthClient;
use App\Permissions\PermissionsHelper;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use MongoDB\Client;
use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\GrantType\RefreshToken;
use OAuth2\GrantType\UserCredentials;
use OAuth2\HttpFoundationBridge\Request;
use OAuth2\HttpFoundationBridge\Response;
use OAuth2\Server;
use OAuth2\Storage\Mongo;

/**
 * OAuth2 wrapper service.
 */
class OAuthService
{
    /** @var \MongoClient */
    protected $mongo;
    /**
     * @var Server
     */
    protected $server;

    use MedusaAudit;

    /**
     * Constructor.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct($app)
    {
        $_hosts = config('database.connections.mongodb.host');
        $_hosts = is_array($_hosts) ? $_hosts : [$_hosts];
        $_dbName = config('database.connections.mongodb.database');

        $this->mongo =
            new Client(
                'mongodb://'.implode(',', $_hosts),
                config('database.connections.mongodb.options', [])
            );

        $_store = new Mongo($this->mongo->selectDatabase($_dbName));

        $this->server = new Server(
            $_store,
            [
                'always_issue_new_refresh_token' => true,
                'refresh_token_lifetime' => 2419200,
            ]
        );

        $_credentials = new MedusaUserCredentials();
        $this->server->addStorage($_credentials, 'user_credentials');
        $this->server->addGrantType(new UserCredentials($_credentials));

        $this->server->addGrantType(new AuthorizationCode($_store));
        $this->server->addGrantType(new ClientCredentials($_store));
        $this->server->addGrantType(
            new RefreshToken(
                $_store,
                [
                    'always_issue_new_refresh_token' => true,
                    'unset_refresh_token_after_use' => true,
                ]
            )
        );
    }

    /**
     * @return \Illuminate\View\View|\OAuth2\HttpFoundationBridge\Response
     */
    public function authorize()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        $this->server->validateAuthorizeRequest($_request, $_response);

        if (! $_response) {
            return $_response;
        }

        $_params = $_request->getAllQueryParameters();
        /** @noinspection PhpUndefinedMethodInspection */
        $_client =
            OauthClient::where('client_id', '=', $_params['client_id'])->first();

        return view(
            'oauth.authorization-form',
            [
                'client' => $_client,
                'params' => $_params,
                'permsObj' => new PermissionsHelper(),
            ]
        );
    }

    /**
     * @return \OAuth2\HttpFoundationBridge\Response
     */
    public function authorizePost()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        /* @noinspection PhpUndefinedFieldInspection */
        $this->server->handleAuthorizeRequest(
            $_request,
            $_response,
            ('Approve' === $_request->get('authorized')),
            Auth::user()->id
        );

        return $_response;
    }

    /**
     * @return \OAuth2\HttpFoundationBridge\Response
     */
    public function token()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        $_response = $this->server->handleTokenRequest($_request, $_response);

        Log::info('Token request');

        return $_response;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        if ($this->server->verifyResourceRequest($_request, $_response)) {
            $_token = $this->server->getAccessTokenData($_request);

            /** @var \User $_user */
            $_user = User::find($_token['user_id']);

            Log::info('Profile request');

            return Response::json(
                [
                    'uid' => $_token['user_id'],
                    'email' => $_user->email_address,
                    'firstname' => $_user->first_name,
                    'lastname' => $_user->last_name,
                    'city' => $_user->city,
                    'state_province' => $_user->state_province,
                    'country' => $_user->country,
                    'imageurl' => $_user->filePhoto,
                    'user_id' => $_token['user_id'],
                    'client' => $_token['client_id'],
                    'expires' => $_token['expires'],
                ]
            );
        }

        return Response::json(
            ['error' => 'Unauthorized'],
            $_response->getStatusCode()
        );
    }

    public function getTisTig()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        Log::info('Time in Service / Time in Grade request');

        if ($this->server->verifyResourceRequest($_request, $_response)) {
            $_token = $this->server->getAccessTokenData($_request);

            /** @var \User $_user */
            /** @noinspection PhpUndefinedMethodInspection */
            $_user =
                User::where(
                    'email_address',
                    '=',
                    strtolower(str_replace(' ', '+', $_token['user_id']))
                )->first();

            return Response::json(
                [
                    'tig' => $_user->getTimeInGrade(true),
                    'tis' => $_user->getTimeInService(true),
                ]
            );
        }

        return Response::json(
            ['error' => 'Unauthorized'],
            $_response->getStatusCode()
        );
    }

    public function updateUser()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        Log::info('User Update Request');

        if ($this->server->verifyResourceRequest($_request, $_response)) {
            $_token = $this->server->getAccessTokenData($_request);

            /** @var \User $_user */
            /** @noinspection PhpUndefinedMethodInspection */
            $_user =
                User::where(
                    'email_address',
                    '=',
                    strtolower(str_replace(' ', '+', $_token['user_id']))
                )->first();

            $_data = Request::all();

            foreach ($_data as $k => $v) {
                $_user->$k = $v;
            }

            if ($_user->save()) {
                $this->writeAuditTrail(
                    $_user->id,
                    'update',
                    'users',
                    (string) $_user->_id,
                    json_encode($_data),
                    'OAuthService@updateUser'
                );

                Log::info('User profile updated');

                return Response::json(
                    [
                        'status' => 'success',
                        'message' => 'Profile updated',
                    ]
                );
                Log::info('We should never get here');
            } else {
                Log::info('There was some sort of problem');

                return Response::json(
                    [
                        'status' => 'error',
                        'message' => 'Unable to update profile',
                    ],
                    500
                );
            }
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        Log::info('User Info Request');

        if ($this->server->verifyResourceRequest($_request, $_response)) {
            $_token = $this->server->getAccessTokenData($_request);

            /** @var \User $_user */
            /** @noinspection PhpUndefinedMethodInspection */
            $_user =
                User::where(
                    'email_address',
                    '=',
                    strtolower(str_replace(' ', '+', $_token['user_id']))
                )->first();
            unset($_user->duty_roster, $_user->password, $_user->osa, $_user->remember_token, $_user->tos);

            $_assignments = $_user->assignment;
            $_lastLogin = strtotime($_user->previous_login);

            foreach ($_assignments as $_index => $_assignment) {
                unset($_assignments[$_index]['chapter_id']);
            }

            $_user->assignment = $_assignments;
            $_exams = $_peerages = [];

            foreach ($_user->getPeerages() as $_peerage) {
                $_peerage['path'] = null;

                if ($_peerage['code'] != 'K' && $_peerage['title'] != 'Knight' && $_peerage['title'] != 'Dame') {
                    if (empty($_peerage['filename']) === false && file_exists(
                            public_path().'/arms/peerage/'.$_peerage['filename']
                        )
                    ) {
                        $_peerage['path'] =
                            '/arms/peerage/'.$_peerage['filename'];
                    }

                    $_peerage['fullTitle'] =
                        $_peerage['generation'].' '.$_peerage['title'].' of '.$_peerage['lands'];
                } else {
                    /** @noinspection PhpUndefinedMethodInspection */
                    /** @var \Korders $orderInfo */
                    $orderInfo =
                        Korders::where(
                            'classes.postnominal',
                            '=',
                            $_peerage['postnominal']
                        )->first();
                    if (file_exists(public_path().'/awards/orders/medals/'.$orderInfo->filename)) {
                        $_peerage['path'] =
                            substr(
                                $orderInfo->filename,
                                0,
                                strrpos($orderInfo->filename, '.')
                            );
                    }

                    $_peerage['fullTitle'] =
                        $orderInfo->getClassName($_peerage['postnominal']).', '.$orderInfo->order;
                }

                unset($_peerage['peerage_id']);
                $_peerages[] = $_peerage;
            }

            $_user->peerages = $_peerages;

            $_schools = \Medusaconfig('exam.regex');
            foreach ($_schools as $_label => $_regex) {
                $_examList = $_user->getExamList(['pattern' => $_regex]);
                $_newExams = false;

                foreach ($_examList as $_id => $_grades) {
                    if (! empty($_grades['date_entered']) && strtotime($_grades['date_entered']) >= $_lastLogin) {
                        $_examList[$_id]['new'] = true;
                        $_newExams = true;
                    }

                    /** @noinspection PhpUndefinedMethodInspection */
                    $_exam = ExamList::where('exam_id', '=', $_id)->first();

                    if (! is_null($_exam)) {
                        $_examList[$_id]['name'] = $_exam->name;
                    }

                    if ($_grades['date'] != 'UNKNOWN') {
                        $_examList[$_id]['date'] =
                            date('d M Y', strtotime($_grades['date']));
                    }

                    unset($_examList[$_id]['entered_by']);

                    $_exams[str_replace(' ', '_', $_label)] =
                        [
                            'label' => $_label,
                            'new' => $_newExams,
                            'examlist' => $_examList,
                        ];
                }
            }

            $_user->exams = $_exams;

            $_user->greeting =
                $_user->getGreeting().' '.$_user->getFullName().$_user->getPostnominals();

            if (! file_exists(public_path().$_user->filePhoto)) {
                unset($_user->filePhoto);
            }

            if (! empty($_user->awards)) {
                $_user->leftRibbonCount = count($_user->getRibbons('L'));
                $_user->leftRibbons = $_user->getRibbons('L');
                $_user->ribbonrack = view('partials.leftribbons', ['user' => $_user])->render();
            } else {
                $_user->ribbonrack = null;
            }

            if (empty($_user->lastUpdate)) {
                $_user->lastUpdate =
                    strtotime($_user->updated_at->toDateTimeString());
            }

            return Response::json($_user);
        }

        return Response::json(
            ['error' => 'Unauthorized'],
            $_response->getStatusCode()
        );
    }

    public function lastUpdated()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        Log::info('Last Updated request');

        if ($this->server->verifyResourceRequest($_request, $_response)) {
            $_token = $this->server->getAccessTokenData($_request);

            /** @var \User $_user */
            /** @noinspection PhpUndefinedMethodInspection */
            $_lastUpdated =
                User::where(
                    'email_address',
                    '=',
                    strtolower(str_replace(' ', '+', $_token['user_id']))
                )
                    ->first()
                    ->getLastUpdated();

            return Response::json(['lastUpdate' => $_lastUpdated]);
        }

        return Response::json(
            ['error' => 'Unauthorized'],
            $_response->getStatusCode()
        );
    }

    public function getIdCard()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        Log::info('ID card requested');

        if ($this->server->verifyResourceRequest($_request, $_response)) {
            $_token = $this->server->getAccessTokenData($_request);

            $_idCard =
                User::where(
                    'email_address',
                    '=',
                    strtolower(str_replace(' ', '+', $_token['user_id']))
                )
                    ->first()
                    ->buildIdCard(true);

            return $_idCard->response('png');
        }

        return Response::json(
            ['error' => 'Unauthorized'],
            $_response->getStatusCode()
        );
    }

    public function getScheduledEvents()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        Log::info('List of scheduled events requested');

        if ($this->server->verifyResourceRequest($_request, $_response)) {
            $_token = $this->server->getAccessTokenData($_request);
            $_tz = Request::get('tz', null);

            Log::info('TZ='.$_tz);

            return Response::json([
                'events' => User::where(
                    'email_address',
                    '=',
                    strtolower(str_replace(' ', '+', $_token['user_id']))
                )
                    ->first()
                    ->getScheduledEvents($_tz),
            ]);
        }

        return Response::json(
            ['error' => 'Unauthorized'],
            $_response->getStatusCode()
        );
    }

    // checkMemberIn($event, $member, $continent = null, $city = null)

    public function checkMemberIn()
    {
        /** @noinspection PhpParamsInspection */
        $_request = Request::createFromRequest(Request::instance());
        $_response = new Response();

        if ($this->server->verifyResourceRequest($_request, $_response)) {
            $_token = $this->server->getAccessTokenData($_request);

            $_data = Request::all();

            Log::info('Attempting to check '.$_data['member'].' in to '.$_data['event']);

            return Response::json(User::where(
                'email_address',
                '=',
                strtolower(str_replace(' ', '+', $_token['user_id']))
            )
                ->first()
                ->checkMemberIn(
                    $_data['event'],
                    $_data['member'],
                    $_data['tz']
                ));
        }

        return Response::json(
            ['error' => 'Unauthorized'],
            $_response->getStatusCode()
        );
    }
}
