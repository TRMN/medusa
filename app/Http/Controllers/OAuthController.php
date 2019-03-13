<?php

namespace App\Http\Controllers;

use App\OAuthClient;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Log;
use Response;

class OAuthController extends Controller
{
    public function index()
    {
        if (($redirect = $this->checkPermissions(['ALL_PERMS'])) !== true) {
            return $redirect;
        }

        $clients = OAuthClient::orderBy('client_name')->get();

        return view('oauth.index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     * GET /billet/create.
     *
     * @return Response
     */
    public function create()
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        return view('oauth.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /billet.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        $validator =
            Validator::make($data = $request->all(), OAuthClient::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $this->writeAuditTrail(
            Auth::user()->id,
            'create',
            'oauth_clients',
            null,
            json_encode($data),
            'OauthController@store'
        );

        OAuthClient::create($data);

        return Redirect::route('oauthclient.index');
    }

    /**
     * Display the specified resource.
     * GET /billet/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /billet/{id}/edit.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(OAuthClient $oauthClient)
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        return view('oauth.edit', ['oauthclient' => $oauthClient]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /billet/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Request $request, \App\OAuthClient $oauthClient)
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        $validator =
            Validator::make($data = $request->all(), OAuthClient::$updateRules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        foreach (['client_id', 'secret', 'redirect', 'name'] as $property) {
            $oauthClient->{$property} = $data[$property];
        }

        $this->writeAuditTrail(
            Auth::user()->id,
            'update',
            'oauth_client',
            null,
            $oauthClient->toJson(),
            'OAuthController@update'
        );

        $oauthClient->save();

        return Redirect::route('oauthclient.index');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /billet/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(\App\OAuthClient $oauthClient)
    {
        try {
            $oauthClient->delete();

            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function profile(Request $request)
    {
        $user = $this->getUserFromRequest($request);

        \Log::info('Profile request');

        return \Response::json(
            [
                'uid'            => $user->_id,
                'email'          => $user->email_address,
                'firstname'      => $user->first_name,
                'lastname'       => $user->last_name,
                'city'           => $user->city,
                'state_province' => $user->state_province,
                'country'        => $user->country,
                'imageurl'       => $user->filePhoto,
                'user_id'        => $user->_id,
            ]
        );
    }

    public function user(Request $request)
    {
        $_user = $this->getUserFromRequest($request);

        Log::info('User Info Request for '.$_user->member_id);

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

            if ($_peerage['code'] == 'L') {
                $_peerage['fullTitle'] = $_peerage['title'].' for '.$_peerage['lands'];
                $_peerage['path'] = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
            } elseif ($_peerage['code'] != 'K' && $_peerage['title'] != 'Knight' && $_peerage['title'] != 'Dame') {
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
                $orderInfo =
                    \App\Korders::where(
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

        $_schools = \App\MedusaConfig::get('exam.regex');
        foreach ($_schools as $_label => $_regex) {
            $_examList = $_user->getExamList(['pattern' => $_regex]);
            $_newExams = false;

            foreach ($_examList as $_id => $_grades) {
                if (!empty($_grades['date_entered']) && strtotime($_grades['date_entered']) >= $_lastLogin) {
                    $_examList[$_id]['new'] = true;
                    $_newExams = true;
                }

                $_exam = \App\ExamList::where('exam_id', '=', $_id)->first();

                if (!is_null($_exam)) {
                    $_examList[$_id]['name'] = $_exam->name;
                }

                if ($_grades['date'] != 'UNKNOWN') {
                    $_examList[$_id]['date'] =
                        date('d M Y', strtotime($_grades['date']));
                }

                unset($_examList[$_id]['entered_by']);

                $_exams[str_replace(' ', '_', $_label)] =
                    [
                        'label'    => $_label,
                        'new'      => $_newExams,
                        'examlist' => $_examList,
                    ];
            }
        }

        $_user->exams = $_exams;

        $_user->greeting =
            $_user->getGreeting().' '.$_user->getFullName().$_user->getPostnominals();

        if (!file_exists(public_path().$_user->filePhoto)) {
            unset($_user->filePhoto);
        }

        if (!empty($_user->awards)) {
            $_user->leftRibbonCount = count($_user->getRibbons('L'));
            $_user->leftRibbons = $_user->getRibbons('L');
            $_user->numAcross = 3;
            $_user->ribbonrack =
                view('partials.leftribbons', ['user' => $_user])->render();
        } else {
            $_user->ribbonrack = null;
        }

        if (empty($_user->lastUpdate)) {
            $_user->lastUpdate =
                strtotime($_user->updated_at->toDateTimeString());
        }

        $_user->promotionPoints = $_user->getTotalPromotionPoints();

        return Response::json($_user);
    }

    public function lastUpdated(Request $request)
    {
        Log::info('Last Updated request');

        $_lastUpdated = $this->getUserFromRequest($request)->getLastUpdated();

        return Response::json(['lastUpdate' => $_lastUpdated]);
    }

    public function getTisTig(Request $request)
    {
        Log::info('Time in Service / Time in Grade request');

        $_user = $this->getUserFromRequest($request);

        return Response::json(
            [
                'tig' => $_user->getTimeInGrade(true),
                'tis' => $_user->getTimeInService(true),
            ]
        );
    }

    public function getIdCard(Request $request)
    {
        Log::info('ID card requested');

        $_idCard = $this->getUserFromRequest($request)->buildIdCard(true);

        return $_idCard->response('png');
    }

    public function getScheduledEvents(Request $request)
    {
        Log::info('List of scheduled events requested');

        $_tz = $request->tz;

        Log::info('TZ='.$_tz);

        return Response::json(
            [
                'events' => $this->getUserFromRequest($request)
                                 ->getScheduledEvents($_tz),
            ]
        );
    }

    public function checkMemberIn(Request $request)
    {
        $_data = $request->all();

        Log::info('Attempting to check '.$_data['member'].' in to '.$_data['event']);

        return Response::json(
            $this->getUserFromRequest($request)
                 ->checkMemberIn(
                     $_data['event'],
                     $_data['member'],
                     empty($_data['tz']) ? null : $_data['tz']
                 )
        );
    }

    public function updateUser(Request $request)
    {
        Log::info('User Update Request');

        $_user = $this->getUserFromRequest($request);

        $_data = $request->all();

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
                'OAuthControllere@updateUser'
            );

            Log::info('User profile updated');

            return Response::json(
                [
                    'status'  => 'success',
                    'message' => 'Profile updated',
                ]
            );
        } else {
            Log::info('There was some sort of problem');

            return Response::json(
                [
                    'status'  => 'error',
                    'message' => 'Unable to update profile',
                ],
                500
            );
        }
    }

    private function getUserFromRequest(Request $request)
    {
        return \App\User::find(json_decode($request->user())->_id);
    }
}
