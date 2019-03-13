<?php

namespace App\Http\Controllers;

use App\Award;
use App\Billet;
use App\Branch;
use App\Chapter;
use App\Country;
use App\Events\EmailChanged;
use App\Events\LoginComplete;
use App\Grade;
use App\Korders;
use App\MedusaConfig;
use App\Permissions\MedusaPermissions;
use App\Ptitles;
use App\Rating;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Webpatser\Countries\Countries;

class UserController extends Controller
{
    use MedusaPermissions;

    /**
     * Get a list of members by branch.
     *
     * @param $branch
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserList($branch, \Illuminate\Http\Request $request)
    {
        $order = $request->input('order');

        /*
         * Branch is used two different ways to avoid having two nearly identical methods and a second route,
         * so check it and do the right thing based on it's value
         *
         */
        switch ($branch) {
            case 'Inactive':
            case 'Suspended':
            case 'Expelled':
                $query = User::where('registration_status', $branch);
                break;
            case 'Bosun':
                $query =
                    User::where('active', 1)
                        ->where('registration_status', 'Active')
                        ->where('assignment.billet', 'Bosun');
                break;
            default:
                $query =
                    User::where('active', 1)
                        ->where('registration_status', 'Active')
                        ->where('branch', $branch);
        }

        $totalRecords = $filteredRecords = $query->count();

        // Need to do any filtering before sort order

        $search = $request->input('search');

        if (empty($search['value']) === false) {
            $searchTerm = '%'.$search['value'].'%';

            $query = $query->where(
                function ($query) use ($searchTerm) {
                    $query->where('last_name', 'like', $searchTerm)
                          ->orWhere('first_name', 'like', $searchTerm)
                          ->orWhere('rank.grade', 'like', $searchTerm)
                          ->orWhere('member_id', 'like', $searchTerm)
                          ->orWhere('email_address', 'like', $searchTerm)
                          ->orWhere('registration_date', 'like', $searchTerm)
                          ->orWhere('assignment.chapter_name', 'like', $searchTerm);
                }
            );

            $filteredRecords = $query->count();
        }

        $sortOrder = $order[0]['dir'];

        switch ($order[0]['column']) {
            case 1:
                $query = $query->orderBy('rank.grade', $sortOrder);
                break;
            case 3:
                $query = $query->orderBy('last_name', $sortOrder)->orderBy(
                    'first_name',
                    $sortOrder
                );
                break;
            case 4:
                $query = $query->orderBy('member_id', $sortOrder);
                break;
            case 5:
                $query = $query->orderBy('email_address', $sortOrder);
                break;
            case 7:
                if ($branch == 'Bosun') {
                    $query = $query->orderBy('branch', $sortOrder);
                } else {
                    $query = $query->orderBy('registration_date', $sortOrder);
                }
                break;
        }

        $users = $query->skip(intval($request->input('start')))->take(
            intval($request->input('length'))
        )->get();

        $ret['draw'] = intval($request->draw);
        $ret['recordsTotal'] = $totalRecords;
        $ret['recordsFiltered'] = $filteredRecords;
        $ret['data'] = [];

        /* @var $user User */
        foreach ($users as $user) {
            $actions = '&nbsp;<a class="fa fa-user my" href="'.route(
                'user.show',
                [$user->id]
            ).'" data-toggle="tooltip" title="View User"></a>';

            if (Auth::user()->hasPermissions(['EDIT_MEMBER']) === true) {
                $actions .= '&nbsp;<a class="tiny fa fa-pencil green" href="'.
                            route(
                                'user.edit',
                                [$user->id]
                            ).
                            '" data-toggle="tooltip" title="Edit User"></a>';
            }

            if (Auth::user()->hasPermissions(['DEL_MEMBER']) === true) {
                $actions .= '&nbsp;<a class="fa fa-close red" href="'.route(
                    'user.confirmdelete',
                    [$user->id]
                ).'" data-toggle="tooltip" title="Delete User"></a>';
            }

            if (Auth::user()->hasPermissions(['ID_CARD']) === true) {
                $actions .= '&nbsp;<a class="fa fa-credit-card';

                $actions .= $user->idcard_printed === true ? ' yellow' : ' green';

                $actions .= '" href="/id/card/'.$user->id.
                            '" data-toggle="tooltip" title="ID Card"></a>&nbsp;';

                $actions .= $user->idcard_printed === true ? '' :
                    '<a class="fa fa-check green idcard-confrim" href="/id/mark/'.
                    $user->id.'" data-toggle="tooltip" title="Mark ID Card as printed" 
                    onclick="return confirm(\'Mark ID card as printed for this member?\')"></a>';
            }

            $ret['data'][] = [
                $user->hasNewExams() === true ?
                    '<span class="fa fa-star red" data-toggle="tooltip" title="New Exams Posted">&nbsp;</span>' :
                    '',
                $user->rank['grade'],
                is_null($user->getTimeInGrade(true)) === false ?
                    $user->getTimeInGrade(true) : 'N/A',
                ($user->branch == 'RMMM' ||
                $user->branch == 'CIVIL') && empty($user->rating) === false ?
                    $user->getFullName(true).' <span class="volkhov">( '.
                    substr($user->rating, 0, 1)
                    .' )</span>' : $user->getFullName(true),
                $user->member_id,
                $user->email_address,
                $user->getAssignmentName('primary') !== false ?
                    '<a href="/chapter/'.$user->getAssignmentId('primary').'">'.
                    $user->getAssignmentName('primary').'</a>' : 'N/A',
                $branch == 'Bosun' ? $user->branch : $user->registration_date,
                $actions,
            ];
        }

        return \response()->json($ret);
    }

    /**
     * Display a listing of users.
     *
     * @return Response
     */
    public function index()
    {
        if (($redirect = $this->checkPermissions('VIEW_MEMBERS')) !== true) {
            return $redirect;
        }

        return view(
            'user.index',
            [
                'title'            => 'Membership List',
                'totalMembers'     => User::where(
                    'registration_status',
                    '=',
                    'Active'
                )->where('active', '=', 1)->count(),
                'totalEnlisted'    => User::where(
                    'registration_status',
                    '=',
                    'Active'
                )->where('active', '=', 1)->where(
                    'rank.grade',
                    'like',
                    'E%'
                )->count(),
                'totalOfficer'     => User::where(
                    'registration_status',
                    '=',
                    'Active'
                )->where('active', '=', 1)->where(
                    'rank.grade',
                    'like',
                    'O%'
                )->count(),
                'totalFlagOfficer' => User::where(
                    'registration_status',
                    '=',
                    'Active'
                )->where('active', '=', 1)->where(
                    'rank.grade',
                    'like',
                    'F%'
                )->count(),
                'totalCivilian'    => User::where(
                    'registration_status',
                    '=',
                    'Active'
                )->where('active', '=', 1)->where(
                    'rank.grade',
                    'like',
                    'C%'
                )->count(),
            ]
        );
    }

    /**
     * Find members with the specified billet.  Blade template sorts by assignment.
     *
     * @param $billet
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function findDuplicateAssignment($billet)
    {
        if (($redirect = $this->checkPermissions('VIEW_MEMBERS')) !== true) {
            return $redirect;
        }

        switch ($billet) {
            case 'CO':
                $billet = 'Commanding Officer';
                break;
            case 'XO':
                $billet = 'Executive Officer';
                break;
            case 'BOSUN':
                $billet = 'Bosun';
                break;
        }

        $users =
            User::where('active', '=', 1)
                ->where('registration_status', '=', 'Active')
                ->where(
                    'assignment.billet',
                    '=',
                    $billet
                )
                ->get();

        return view(
            'user.duplicates',
            ['users' => $users, 'title' => 'Show '.$billet]
        );
    }

    /**
     * Show Password reset form.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReset(User $user)
    {
        return view('user.reset', ['user' => $user]);
    }

    /**
     * Process password reset request.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReset(User $user)
    {
        $in =
            Request::only(
                [
                    'current_password',
                    'password',
                    'password_confirmation',
                ]
            );

        // Did they enter their current password?

        if (Hash::make($in['current_password']) !== $user->getAuthPassword()) {
            return Redirect::route('user.getReset', [$user->id])->with(
                'message',
                'Please re-enter your current password'
            );
        }

        // Does the new password and confirmation match?

        if ($in['password'] === $in['password_confirmation']) {
            // Check that it meets some minimum standards
            $rules['password'] = 'required|min:8';
            $errMsg['password.min'] =
                'The password must be at least 8 characters long';
            $validator = Validator::make($in, $rules, $errMsg);

            if ($validator->fails()) {
                return Redirect::route('user.getReset', [$user->id])->with(
                    'message',
                    'The password must be at least 8 characters long'
                );
            }

            // Everything is good, reset the password, update their record in the database
            $user->password = Hash::make($in['password']);

            $this->writeAuditTrail(
                (string) Auth::user()->id,
                'update',
                'users',
                (string) $user->id,
                'Password Change',
                'UserController@postReset'
            );
            $user->save();

            return Redirect::route('home')
                           ->with('message', 'Your password has been changed');
        } else {
            return Redirect::route('user.getReset', [$user->id])
                           ->with('message', 'The passwords do not match');
        }
    }

    /**
     * Show list of pending applications.
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function reviewApplications()
    {
        if (($redirect =
                $this->checkPermissions('PROC_APPLICATIONS')) !== true
        ) {
            return $redirect;
        }

        $users =
            User::where('active', '!=', '1')
                ->where('registration_status', '=', 'Pending')
                ->get();

        return view(
            'user.review',
            [
                'users' => $users,
                'title' => 'Approve Membership Applications',
            ]
        );
    }

    /**
     * Process approval of a pending application.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveApplication(User $user)
    {
        if (($redirect =
                $this->checkPermissions('PROC_APPLICATIONS')) !== true
        ) {
            return $redirect;
        }

        $events[] = 'Applied to '.Branch::getBranchName($user->branch).' on '.
                    date('d M Y', strtotime($user->application_date));

        $user->registration_status = 'Active';
        $user->registration_date = date('Y-m-d');
        $user->active = 1;

        switch ($user->branch) {
            case 'RMN':
            case 'GSN':
            case 'RHN':
            case 'IAN':
                $billet = 'Crewman';

                $dob = new \DateTime($user->dob);
                $ageCutOff = new \DateTime('now');
                $ageCutOff->modify('-18 year');

                if ($ageCutOff < $dob) {
                    $billet = 'Midshipman';
                }

                $assignment = $user->assignment;
                $assignment[0]['billet'] = $billet;
                $user->assignment = $assignment;

                break;
            case 'RMMC':
                $assignment = $user->assignment;
                $assignment[0]['billet'] = 'Marine';
                $user->assignment = $assignment;

                break;
            case 'RMA':
                $assignment = $user->assignment;
                $assignment[0]['billet'] = 'Soldier';
                $user->assignment = $assignment;

                break;
            case 'RMMM':
                $assignment = $user->assignment;
                $assignment[0]['billet'] = 'Crewman';
                $user->assignment = $assignment;

                break;
            case 'RMACS':
                $assignment = $user->assignment;
                $assignment[0]['billet'] = 'Trainee';
                $user->assignment = $assignment;

                break;
            case 'SFS':
                $assignment = $user->assignment;
                $assignment[0]['billet'] = 'Cadet Ranger';
                $user->assignment = $assignment;

                break;
            default:
                $assignment = $user->assignment;
                $assignment[0]['billet'] = 'Civilian';
                $user->assignment = $assignment;
        }

        $rank = $user['rank'];
        $rank['date_of_rank'] = date('Y-m-d');
        $user->rank = $rank;
        $user->member_id = 'RMN'.User::getFirstAvailableMemberId();

        $events[] = 'Application approved by BuPers; Enlisted at rank of '.
                    Grade::getRankTitle($user->rank['grade'], null, $user->branch).
                    ' ('.$user->rank['grade'].') and assigned to '.
                    $user->getAssignmentName('primary').' on '.date('d M Y');

        $user->permissions = [
            'LOGOUT',
            'CHANGE_PWD',
            'EDIT_SELF',
            'ROSTER',
            'TRANSFER',
        ];

        $user->lastUpdate = time();

        $this->writeAuditTrail(
            (string) Auth::user()->id,
            'update',
            'users',
            (string) $user->id,
            $user->toJson(),
            'UserController@approveApplication'
        );

        $user->save();

        // Update the service history

        foreach ($events as $event) {
            $user->addServiceHistoryEntry(
                ['timestamp' => time(), 'event' => $event]
            );
        }

        // Get Chapter CO's email
        $user->co_email =
            Chapter::find($user->getPrimaryAssignmentId())
                   ->getCO()->email_address;

        // Send welcome email
        Mail::send(
            'emails.welcome',
            ['user' => $user],
            function ($message) use ($user) {
                $message->from('membership@trmn.org', 'TRMN Membership');

                $message->to($user->email_address)->bcc($user->co_email);

                $message->subject('TRMN Membership');
            }
        );

        return Redirect::route('user.review');
    }

    /**
     * Deny a pending application.
     *
     * @param \App\User $user
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function denyApplication(User $user)
    {
        if (($redirect =
                $this->checkPermissions('PROC_APPLICATIONS')) !== true
        ) {
            return $redirect;
        }

        $user->registration_status = 'Denied';
        $user->registration_date = date('Y-m-d');

        $user->lastUpdate = time();

        $this->writeAuditTrail(
            (string) Auth::user()->id,
            'update',
            'users',
            (string) $user->id,
            $user->toJson(),
            'UserController@denyApplication'
        );

        $user->save();

        return Redirect::route('user.review');
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create()
    {
        if (($redirect = $this->checkPermissions('ADD_MEMBER')) !== true) {
            return $redirect;
        }

        return view(
            'user.create',
            [
                'user'      => new User(),
                'countries' => Country::getCountries(),
                'branches'  => Branch::getBranchList(),
                'grades'    => Grade::getGradesForBranch('RMN'),
                'ratings'   => Rating::getRatingsForBranch('RMN'),
                'chapters'  => ['' => 'Start typing to search for a chapter'] +
                               Chapter::getFullChapterList(),
                'billets'   => ['' => 'Select a Billet'] + Billet::getBillets(),
                //            'locations' => ['0' => 'Select a Location'] + Chapter::getChapterLocations(),

            ]
        );
    }

    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (($redirect = $this->checkPermissions('ADD_MEMBER')) !== true) {
            return $redirect;
        }

        $rules = User::$rules;
        $errMsg = User::$error_message;

        $rules['password'] = 'required|min:8';
        $errMsg['password.required'] = 'You must set a password for the user';
        $errMsg['password.min'] =
            'The password must be at least 8 characters long';
        $validator = Validator::make($data = \Request::all(), $rules, $errMsg);

        if ($validator->fails()) {
            return Redirect::route('user.create')
                           ->withErrors($validator)
                           ->withInput();
        }

        // Massage the data a little bit.  First, build up the rank array

        $data['rank'] = [
            'grade'        => $data['display_rank'],
            'date_of_rank' => date(
                'Y-m-d',
                strtotime($data['dor'])
            ),
        ];
        unset($data['display_rank'], $data['dor']);

        // Build up the member assignments

        $chapterName = Chapter::find($data['primary_assignment'])->chapter_name;

        $assignment[] = [
            'chapter_id'    => $data['primary_assignment'],
            'chapter_name'  => $chapterName,
            'date_assigned' => date(
                'Y-m-d',
                strtotime($data['primary_date_assigned'])
            ),
            'billet'        => $data['primary_billet'],
            'primary'       => true,
        ];

        unset($data['primary_assignment'], $data['primary_date_assigned'], $data['primary_billet']);

        if (isset($data['secondary_assignment']) === true &&
            empty($data['secondary_assignment']) === false) {
            $chapterName =
                Chapter::find($data['secondary_assignment'])->chapter_name;

            $assignment[] = [
                'chapter_id'    => $data['secondary_assignment'],
                'chapter_name'  => $chapterName,
                'date_assigned' => date(
                    'Y-m-d',
                    strtotime($data['secondary_date_assigned'])
                ),
                'billet'        => $data['secondary_billet'],
                'secondary'     => true,
            ];
        }

        unset($data['secondary_assignment'], $data['secondary_date_assigned'], $data['secondary_billet']);

        $data['assignment'] = $assignment;

        // Hash the password

        $data['password'] = Hash::make($data['password']);

        // Assign a member id

        $data['member_id'] =
            'RMN'.User::getFirstAvailableMemberId(empty($data['honorary']));

        if (isset($data['honorary']) === true && $data['honorary'] === '1') {
            $data['member_id'] .= '-H';
            unset($data['honorary']);
        }

        // Set the active flag, application date and registration date

        $data['active'] = '1';
        $data['registration_status'] = 'Active';

        $data['application_date'] = date('Y-m-d');
        $data['registration_date'] = date('Y-m-d');

        // Normalize State and Province
        $data['state_province'] =
            User::normalizeStateProvince($data['state_province']);

        // Standard User Permissions
        $data['permissions'] = [
            'LOGOUT',
            'CHANGE_PWD',
            'EDIT_SELF',
            'ROSTER',
            'TRANSFER',
        ];

        // For future use

        $data['peerage_record'] = [];

        $data['awards'] = [];

        unset($data['_token'], $data['password_confirmation']);

        $data['email_address'] = strtolower($data['email_address']);

        $data['lastUpdate'] = time();

        $this->writeAuditTrail(
            (string) Auth::user()->id,
            'create',
            'users',
            null,
            json_encode($data),
            'UserController@store'
        );

        $user = User::create($data);

        // Until I figure out why mongo drops fields, I'm doing this hack!

        $u = User::find($user['id']);

        foreach ($data as $key => $value) {
            $u->$key = $value;
        }

        $u->save();

        Event::fire('user.created', $user);

        return Redirect::route('user.index');
    }

    /**
     * Store a new applicant.
     *
     * @return Response
     */
    public function apply()
    {
        $rules = [
            'email_address'      => 'required|email|unique:users',
            'first_name'         => 'required|min:2',
            'last_name'          => 'required|min:2',
            'address1'           => 'required|min:4',
            'city'               => 'required|min:2',
            'state_province'     => 'required|min:2',
            'postal_code'        => 'required|min:2',
            'country'            => 'required|min:2',
            'password'           => 'required|confirmed',
            'dob'                => 'required|date|date_format:Y-m-d',
            'branch'             => 'required',
            'primary_assignment' => 'required|min:2',
            'tos'                => 'required',
        ];

        $error_message = [
            'first_name.required'         => 'Please enter your first name',
            'first_name.min'              => 'Your first name must be at least 2 characters long',
            'last_name.required'          => 'Please enter your last name',
            'last_name.min'               => 'Your last name must be at least 2 characters long',
            'address1.required'           => 'Please enter your street address',
            'address1.min'                => 'The street address must be at least 4 characters long',
            'city.required'               => 'Please enter your city',
            'city.min'                    => 'Your city must be at least 2 characters long',
            'state_province.required'     => 'Please enter your state or province',
            'state_province.min'          => 'Your state or province must be at least 2 characters long',
            'postal_code.required'        => 'Please enter your zip or postal code',
            'postal_code.min'             => 'Your zip or postal code must be at least 2 characters long',
            'country.required'            => 'Please enter your country',
            'country.min'                 => 'Your country must be at least 2 characters long',
            'dob.required'                => 'Please enter your date of birth',
            'dob.date_format'             => 'Please enter your date of birth in the YYYY-MM-DD format',
            'dob.date'                    => 'Please enter a valid date of birth',
            'primary_assignment.required' => 'Please select a chapter',
            'primary_assignment.min'      => 'Please select a chapter',
            'branch.required'             => 'Please select the members branch',
            'email_address.unique'        => 'That email address is already in use',
            'email_address.required'      => 'Please enter your email address',
            'tos.required'                => 'You must agree to the Terms of Service to apply',
        ];

        $data = \Request::all();

        if (isset($data['mobile']) === false) {
            $validator = Validator::make($data, $rules, $error_message);

            if ($validator->fails()) {
                return redirect('register')
                    ->withErrors($validator)
                    ->withInput();
            }

            if (in_array(
                $_SERVER['SERVER_NAME'],
                ['medusa.dev',
                 'medusa-dev.trmn.org',
                 'medusa.local',
                 'localhost', ]
            ) === false) {
                // Check Captcha
                $secret = config('recaptcha.secret');
                $captcha = \Request::get('g-recaptcha-response', null);

                if (empty($captcha) === false) {
                    $recaptcha = new \ReCaptcha\ReCaptcha($secret);

                    $resp = $recaptcha->verify($captcha, $_SERVER['REMOTE_ADDR']);

                    if ($resp->isSuccess() === false) {
                        return redirect('register')
                            ->withErrors(
                                ['message' => 'Please prove that you\'re a sentient being']
                            )
                            ->withInput();
                    }
                } else {
                    return redirect('register')
                        ->withErrors(
                            ['message' => 'Please prove that you\'re a sentient being']
                        )
                        ->withInput();
                }
            }
        }

        $data['rank'] = ['grade' => 'E-1', 'date_of_rank' => date('Y-m-d')];

        switch ($data['branch']) {
            case 'CIVIL':
            case 'INTEL':
                $data['rank']['grade'] = 'C-1';
                $billet = 'Civilian One';
                break;
            case 'SFS':
                $data['rank']['grade'] = 'C-1';
                $billet = 'Cadet Ranger One';
                break;
            case 'RMMM':
                $data['rank']['grade'] = 'C-1';
                $billet = 'Apprentice Merchant Spacer';
                break;
            case 'RMACS':
                $data['rank']['grade'] = 'C-1';
                $billet = 'Trainee';
                break;
            case 'RMMC':
                $billet = 'Marine';
                break;
            case 'RMA':
                $billet = 'Soldier';
                break;
            default:
                $billet = 'Crewman';
        }

        if (isset($data['primary_assignment']) === true &&
            empty($data['primary_assignment']) === false) {
            $chapterName =
                Chapter::find($data['primary_assignment'])->chapter_name;

            $data['assignment'][] = [
                'chapter_id'    => $data['primary_assignment'],
                'chapter_name'  => $chapterName,
                'date_assigned' => date('Y-m-d'),
                'billet'        => $billet,
                'primary'       => true,
            ];
        } else {
            $data['assignment'][] = [];
        }

        unset($data['primary_assignment'], $data['primary_date_assigned'], $data['primary_billet'], $data['captcha']);

        // Hash the password

        $data['password'] = Hash::make($data['password']);

        // Normalize State and Province
        $data['state_province'] =
            User::normalizeStateProvince($data['state_province']);

        // For future use

        $data['peerage_record'] = $data['history'] = $data['awards'] = [];
        $data['active'] = 0;
        $data['application_date'] = date('Y-m-d');
        $data['registration_status'] = 'Pending';

        unset($data['_token'], $data['password_confirmation']);

        $data['email_address'] = strtolower($data['email_address']);

        asort($data);

        $data['lastUpdate'] = time();

        $this->writeAuditTrail(
            'Guest from '.\Request::getClientIp(),
            'create',
            'users',
            null,
            json_encode($data),
            'UserController@apply'
        );

        $user = User::create($data);

        Event::fire('user.registered', $user);

        if (isset($data['mobile']) === true) {
            if (empty($user->id)) {
                // No id, insert didn't happen
                return Response::json(
                    [
                        'status'  => 'error',
                        'message' => 'Unable to create user',
                    ],
                    500
                );
            } else {
                return Response::json(
                    [
                        'status'  => 'success',
                        'message' => 'User created',
                    ]
                );
            }
        } else {
            return view('thankyou');
        }
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     *
     * @return Response
     */
    public function show(User $user, $message = null)
    {
        if (Auth::check() === false) {
            return redirect('/login');
        }

        if ($this->isInChainOfCommand($user) === false &&
            Auth::user()->id != $user->id &&
            $this->hasPermissions(
                [
                    'VIEW_MEMBERS',
                    'VIEW_'.$user->branch,
                ]
            ) === false
        ) {
            return redirect(URL::previous())
                ->with(
                    'message',
                    'You do not have permission to view that page'
                );
        }

        if (empty(Auth::user()->osa) === true) {
            return view(
                'osa',
                ['showform' => true, 'greeting' => Auth::user()->getGreetingArray()]
            );
        }

        $titles[''] = 'Select Peerage';

        foreach (Ptitles::orderBy('precedence')->get() as $title) {
            $titles[$title->title] = $title->title;
        }

        $orders[''] = 'Select Order';

        foreach (Korders::all() as $order) {
            $orders[$order->id] = $order->order;
        }

        $user->leftRibbons = $user->getRibbons('L');
        $user->leftRibbonCount = count($user->leftRibbons);
        $user->numAcross = 3;

        return view(
            'user.show',
            [
                'user'      => $user,
                'countries' => Country::getCountries(),
                'branches'  => Branch::getBranchList(),
                'ptitles'   => $titles,
                'korders'   => $orders,
                'message'   => $message,
            ]
        );
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param User $user
     *
     * @return Response
     */
    public function edit(User $user)
    {
        if (($this->hasPermissions(['EDIT_SELF']) === true &&
             Auth::user()->id == $user->id) || $this->hasPermissions(
                 ['EDIT_MEMBER']
             ) === true
        ) {
            $greeting = $user->getGreetingArray();

            if (isset($user->rating) === true && empty($user->rating) === false &&
                is_array(
                    $user->rating
                ) === false
            ) {
                $user->rating =
                    [
                        'rate'        => $user->rating,
                        'description' => Rating::where(
                            'rate_code',
                            '=',
                            $user->rating
                        )->get()[0]->rate['description'],
                    ];
            }

            $user->display_rank = $user->rank['grade'];

            if (isset($user->rank['date_of_rank'])) {
                $user->dor = $user->rank['date_of_rank'];
            } else {
                $user->dor = '';
            }

            $user->primary_assignment = $user->getPrimaryAssignmentId();
            $user->primary_billet = $user->getPrimaryBillet();
            $user->primary_date_assigned = $user->getPrimaryDateAssigned();

            $user->secondary_assignment = $user->getSecondaryAssignmentId();
            $user->secondary_billet = $user->getSecondaryBillet();
            $user->secondary_date_assigned = $user->getSecondaryDateAssigned();

            $user->additional_assignment = $user->getAssignmentId('additional');
            $user->additional_billet = $user->getBillet('additional');
            $user->additional_date_assigned =
                $user->getDateAssigned('additional');

            $user->extra_assignment = $user->getAssignmentId('extra');
            $user->extra_billet = $user->getBillet('extra');
            $user->extra_date_assigned = $user->getDateAssigned('extra');

            if (empty($user->permissions) === true) {
                $user->permissions = [
                    'LOGOUT',
                    'CHANGE_PWD',
                    'EDIT_SELF',
                    'ROSTER',
                    'TRANSFER',
                ];
            }

//            $chapters = ;
            return view(
                'user.edit',
                [
                    'user'        => $user,
                    'greeting'    => $greeting,
                    'countries'   => Country::getCountries(),
                    'branches'    => Branch::getBranchList(),
                    'grades'      => Grade::getGradesForBranch($user->branch),
                    'ratings'     => Rating::getRatingsForBranch($user->branch),
                    'chapters'    => $user->hasPermissions(['EDIT_MEMBER']) ===
                                     true ?
                        ['' => 'Start typing to search for a chapter'] +
                        Chapter::getFullChapterList() : Chapter::getChapters(
                            null,
                            0,
                            false
                        ),
                    'billets'     => ['' => 'Select a billet'] +
                                     Billet::getBillets(),
                    'locations'   => ['' => 'Select a Location'] +
                                     Chapter::getChapterLocations(),
                    'permissions' => DB::table('permissions')
                                       ->orderBy('name', 'asc')
                                       ->get(),

                ]
            );
        } else {
            return redirect(URL::previous())
                ->with(
                    'message',
                    'You do not have permission to view that page'
                );
        }
    }

    /**
     * Update the specified user in storage.
     *
     * @param User $user
     *
     * @return Response
     */
    public function update(User $user)
    {
        if (($redirect =
                $this->checkPermissions(['EDIT_MEMBER', 'EDIT_SELF'])) !== true
        ) {
            return $redirect;
        }

        $validator =
            Validator::make(
                $data = \Request::all(),
                User::$updateRules,
                User::$error_message
            );

        if ($validator->fails()) {
            return redirect(URL::previous())
                ->withErrors($validator)
                ->withInput();
        }

        $rank = $history = [];

        $transfer = 0; // Flag for this being a transfer

        // Branch change?
        if ($user->branch != $data['branch']) {
            $transfer = time();

            $history[] = [
                'timestamp' => $transfer,
                'event'     => 'Transferred from '.
                               Branch::getBranchName($user->branch).' to '.
                               Branch::getBranchName($data['branch']).' on '.
                               date('d M Y'),
            ];
        }

        // Massage the data a little bit.  First, build up the rank array

        if (empty($data['display_rank']) === false ||
            empty($data['rating']) === false) {
            $data['rank'] = ['grade' => $data['display_rank']];

            if (empty($data['dor']) === true) {
                $data['rank']['date_of_rank'] = '';
            } else {
                $data['rank']['date_of_rank'] =
                    date(
                        'Y-m-d',
                        $transfer == 0 ? strtotime($data['dor']) : $transfer
                    );
            }

            // Check and see if there is a change in rank
            if ($user->rank['grade'] != $data['display_rank']) {
                $history[] = [
                    'timestamp' => $transfer == 0 ? strtotime($data['dor']) :
                        $transfer + 1,
                    'event'     => 'Rank changed from '.
                                   Grade::getRankTitle($user->rank['grade'], $user->getRate(), $user->branch).' ('.
                                   $user->rank['grade'].') to '.
                                   Grade::getRankTitle(
                                       $data['display_rank'],
                                       !empty($data['rating']) ? $data['rating'] : null,
                                       $data['branch']
                                   ).' ('.$data['display_rank'].') on '.
                                   date('d M Y', $transfer == 0 ? strtotime($data['dor']) : $transfer),
                ];

                // Is this an early promotion?

                if (empty($data['ep']) === false && $data['ep'] == '1') {
                    // Get TiG requirement of new grade
                    $requirements = Grade::getRequirements($data['display_rank']);

                    // Calculate how many months early the promotion is and update the number of points
                    $data['points'] = $user->points;

                    if (empty($data['points']['ep']) === true) {
                        $data['points']['ep'] = 0;
                    }

                    $data['points']['ep'] -= $requirements['tig'] -
                                             $user->getTimeInGrade('months');
                    $data['rank']['early'] = $data['rank']['date_of_rank'];
                }
            }

            // Check for a change in rating
            $rate = $user->getRate();

            if ($rate != $data['rating']) {
                $branch = empty($rate) === false ? $user->branch : $data['branch'];

                switch ($branch) {
                    case 'RMMM':
                        $event = 'Merchant Marine Division ';
                        break;
                    case 'CIVIL':
                        $event = 'Civilian Speciality ';
                        break;
                    default:
                        $event = $branch.' Rating ';
                }

                $old = ($user->branch === $branch && empty($rate) === false) ? Rating::getRateName($rate).' ('.$rate.') ' : null;

                $new = (empty($data['rating']) === false) ? Rating::getRateName($data['rating']).
                        ' ('.$data['rating'].')' : null;

                if (empty($data['rating']) === true) {
                    // Rating has been removed
                    $event .= $old.' removed';
                } elseif (empty($rate) === true) {
                    $event .= $new.' added';
                } else {
                    // Rating has changed
                    $event .= $old.' changed to '.$new;
                }

                $event .= ' on '.date('d M Y');

                $history[] = [
                    'timestamp' => time(),
                    'event'     => $event,
                ];
            }

            unset($data['display_rank'], $data['dor']);
        }

        // Build up the member assignments

        $chapterName = Chapter::find($data['primary_assignment'])->chapter_name;

        $assignment[] = [
            'chapter_id'    => $data['primary_assignment'],
            'chapter_name'  => $chapterName,
            'date_assigned' => date(
                'Y-m-d',
                strtotime($data['primary_date_assigned'])
            ),
            'billet'        => $data['primary_billet'],
            'primary'       => true,
        ];

        unset($data['primary_assignment'], $data['primary_date_assigned'], $data['primary_billet']);

        if (isset($data['secondary_assignment']) === true &&
            empty($data['secondary_assignment']) === false) {
            $chapterName =
                Chapter::find($data['secondary_assignment'])->chapter_name;

            $assignment[] = [
                'chapter_id'    => $data['secondary_assignment'],
                'chapter_name'  => $chapterName,
                'date_assigned' => date(
                    'Y-m-d',
                    strtotime($data['secondary_date_assigned'])
                ),
                'billet'        => $data['secondary_billet'],
                'secondary'     => true,
            ];

            unset($data['secondary_assignment'], $data['secondary_date_assigned'], $data['secondary_billet']);
        }

        if (isset($data['additional_assignment']) === true &&
            empty($data['additional_assignment']) === false) {
            $chapterName =
                Chapter::find($data['additional_assignment'])->chapter_name;

            $assignment[] = [
                'chapter_id'    => $data['additional_assignment'],
                'chapter_name'  => $chapterName,
                'date_assigned' => date(
                    'Y-m-d',
                    strtotime($data['additional_date_assigned'])
                ),
                'billet'        => $data['additional_billet'],
                'additional'    => true,
            ];

            unset($data['additional_assignment'], $data['additional_date_assigned'], $data['additional_billet']);
        }

        if (isset($data['extra_assignment']) === true &&
            empty($data['extra_assignment']) === false) {
            $chapterName =
                Chapter::find($data['extra_assignment'])->chapter_name;

            $assignment[] = [
                'chapter_id'    => $data['extra_assignment'],
                'chapter_name'  => $chapterName,
                'date_assigned' => date(
                    'Y-m-d',
                    strtotime($data['extra_date_assigned'])
                ),
                'billet'        => $data['extra_billet'],
                'extra'         => true,
            ];

            unset($data['extra_assignment'], $data['extra_date_assigned'], $data['extra_billet']);
        }

        $data['assignment'] = $assignment;

        // Check for changes in billets or assignments

        foreach ($assignment as $item) {
            $position = 'primary';

            if (empty($item['secondary']) === false) {
                $position = 'secondary';
            } elseif (empty($item['additional']) === false) {
                $position = 'additional';
            } elseif (empty($item['extra']) === false) {
                $position = 'extra';
            }

            $currentValue = $user->getFullAssignmentInfo($position);

            // Did this assignment change?
            if ($item['chapter_id'] !== $currentValue['chapter_id']) {
                $history[] = [
                    'timestamp' => strtotime($item['date_assigned']),
                    'event'     => ucfirst($position).' assignment changed to '.
                                   $item['chapter_name'].' and assigned as '.
                                   $item['billet'].' on '.date(
                                       'd M Y',
                                       strtotime($item['date_assigned'])
                                   ),
                ];
            } elseif ($item['billet'] !== $currentValue['billet']) {
                // Only the billet changed
                $history[] = [
                    'timestamp' => strtotime($item['date_assigned']),
                    'event'     => ucfirst($position).' billet changed from '.
                                   $currentValue['billet'].' to '.
                                   $item['billet'].' on '.date(
                                       'd M Y',
                                       strtotime($item['date_assigned'])
                                   ),
                ];
            }
        }

        // Merge new history with existing history

        if (empty($user->history) === false && empty($history) === false) {
            $history = array_merge($user->history, $history);
        }

        if (empty($history) === false) {
            $history = array_values(
                Arr::sort(
                    $history,
                    function ($value) {
                        return $value['timestamp'];
                    }
                )
            );

            $data['history'] = $history;
        }

        if (isset($data['password']) === true &&
            empty($data['password']) === false) {
            // Hash the password

            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Normalize State and Province
        $data['state_province'] =
            User::normalizeStateProvince($data['state_province']);
        $data['state_province'] =
            User::normalizeStateProvince($data['state_province']);

        $data['awards'] = [];

        unset($data['_method'], $data['_token'], $data['password_confirmation']);

        // Normal user edits don't set permissions as an array but as serialized data.  Need to deal with that
        if ($this->hasPermissions(['ASSIGN_PERMS']) === false) {
            $data['permissions'] = $user->permissions;
        } else {
            if (empty($user->permissions) === true) {
                $currentPermissions = [];
            } else {
                $currentPermissions = $user->permissions;
                sort($currentPermissions);
            }

            $newPermissions = $data['permissions'];

            if (in_array('CONFIG', $currentPermissions) === true &&
                in_array('CONFIG', $newPermissions) === false &&
                in_array('CONFIG', Auth::user()->permissions) === false
            ) {
                // CONFIG perm in user record, not in submitted perms and logged in user does not have CONFIG perm
                $data['permissions'][] = 'CONFIG';
            }

            sort($newPermissions);

            if ($currentPermissions !== $newPermissions) {
                $data['osa'] = false;
            }
        }

        $data['email_address'] = strtolower($data['email_address']);

        // Check for email address.  If it's changed, fire the EmailChanged event

        if ($user->email_address != $data['email_address']) {
            $oldEmail = $user->email_address;
        }

        $data['duty_roster'] = trim($data['duty_roster'], ',');

        $data['lastUpdate'] = time();

        $data['awards'] = $user->awards;

        try {
            $user->update($data);

            $this->writeAuditTrail(
                (string) Auth::user()->id,
                'update',
                'users',
                (string) $user->id,
                json_encode($data),
                'UserController@update'
            );

            if ($data['reload_form'] === 'yes') {
                $redirect = Response::redirectToRoute('user.edit', [$user->id]);
            } else {
                $redirect = Response::redirectTo($data['redirectTo']);
            }

            if (isset($oldEmail) === true) {
                event(new EmailChanged($oldEmail, $data['email_address']));
            }
        } catch (\Exception $d) {
            return redirect()->to('/user/'.$user->id)->with(
                'error',
                'There was a problem saving your changes.'
            );
        }

        Cache::flush();

        return $redirect;
    }

    /**
     * Process acceptance of the Terms of Service.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tos()
    {
        $this->loginValid();

        $data = \Request::all();

        if (empty($data['tos']) === false) {
            $user = User::find($data['id']);
            $user->tos = true;

            $this->writeAuditTrail(
                (string) Auth::user()->id,
                'update',
                'users',
                (string) $user->id,
                $user->toJson(),
                'UserController@tos'
            );

            $user->save();

            return redirect()->to(session('url.intended'));
        }

        return redirect()->to('signout');
    }

    /**
     * Process acceptance of the Official Secrets Act.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function osa()
    {
        $this->loginValid();

        $data = \Request::all();

        if (empty($data['osa']) === false) {
            $user = User::find($data['id']);
            $user->osa = date('Y-m-d');

            $this->writeAuditTrail(
                (string) Auth::user()->id,
                'update',
                'users',
                (string) $user->id,
                $user->toJson(),
                'UserController@osa'
            );

            $user->save();

            return redirect()->to(session('url.intended'));
        }

        return redirect()->to('signout');
    }

    /**
     * Confirm that the user should be deleted.
     *
     * @param User $user
     *
     * @return Response
     */
    public function confirmDelete(User $user)
    {
        if (($redirect = $this->checkPermissions('DEL_MEMBER')) !== true) {
            return $redirect;
        }

        return view('user.confirm-delete', ['user' => $user]);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     *
     * @return Response
     */
    public function destroy(User $user)
    {
        if (($redirect = $this->checkPermissions('DEL_MEMBER')) !== true) {
            return $redirect;
        }

        $this->writeAuditTrail(
            (string) Auth::user()->id,
            'hard delete',
            'users',
            (string) $user->id,
            $user->toJson(),
            'UserController@destroy'
        );

        User::destroy($user->id);

        Cache::flush();

        return Redirect::route('user.index');
    }

    /**
     * Show the sign up page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register()
    {
        $fullBranchList = Branch::all();
        $branches = [];

        foreach ($fullBranchList as $branch) {
            $branches[$branch['branch']] = $branch['branch_name'];
        }

        asort($branches);

        $viewData = [
            'user'      => new User(),
            'countries' => Country::getCountries(),
            'branches'  => $branches,
            'chapters'  => ['' => 'Start typing to search for a chapter'] +
                           Chapter::getFullChapterList(false),
            'register'  => true,
        ];

        return view('user.register', $viewData);
    }

    /**
     * Build up a peerage record from the provided data.
     *
     * @param array $data
     *
     * @return mixed
     */
    private function buildPeerageRecord(array $data)
    {
        $peerage['title'] = $data['ptitle'];

        $pTitleInfo = Ptitles::where('title', '=', $data['ptitle'])->first();

        $peerage['code'] = $pTitleInfo->code;

        if ($data['ptitle'] == 'Knight' || $data['ptitle'] == 'Dame') {
            $kOrder =
                Korders::where('classes.postnominal', '=', $data['class'])
                       ->first();

            // Use the precedence from the Knight Orders table
            $peerage['precedence'] =
                $kOrder->getPrecedence(
                    [
                        'type'  => 'postnominal',
                        'value' => $data['class'],
                    ]
                );
            $peerage['postnominal'] = $data['class'];

            if (substr(
                $kOrder->getClassName($data['class']),
                0,
                6
            ) != 'Knight'
            ) {
                $peerage['code'] = '';
            }
        } else {
            $peerage['precedence'] = $pTitleInfo->precedence;
            $peerage['generation'] = $data['generation'];
            $peerage['lands'] = $data['lands'];

            if (\Request::hasFile('arms') === true && \Request::file('arms')
                                                              ->isValid() === true
            ) {
                $peerage['filename'] =
                    basename(\Request::file('arms')->store('peerage', 'arms'));
            }
        }

        if (empty($data['courtesy']) === false) {
            $peerage['courtesy'] = true;
        }

        if (empty($data['peerage_id']) === true) {
            // Give each entry a unique ID so we can edit or delete them later with ease

            $peerage['peerage_id'] = uniqid(null, true);
        } else {
            $peerage['peerage_id'] = $data['peerage_id'];
        }

        return $peerage;
    }

    /**
     * Process AJAX request to add or edit a peerage.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addOrEditPeerage(User $user)
    {
        $data = \Request::all();

        $msg = 'Peerage added';

        if (empty($data['peerage_id']) === false) {
            // This is an edit
            $user->deletePeerage($data['peerage_id']);
            $msg = 'Peerage updated';
        }

        $peerage = $this->buildPeerageRecord($data);

        if (empty($data['filename']) === false &&
            empty($peerage['filename']) === true) {
            // Peerage entry had a file name set.  No new image uploaded
            $peerage['filename'] = $data['filename'];
        }

        $currentPeerages = $user->peerages;
        $currentPeerages[] = $peerage;

        $user->peerages = $currentPeerages;

        $this->writeAuditTrail(
            (string) Auth::user()->id,
            'update',
            'users',
            (string) $user->id,
            $user->toJson(),
            'UserController@addOrEditPeerage'
        );

        $user->save();

        return redirect()->to(URL::previous())->with('message', $msg);
    }

    /**
     * Process AJAX request to delete a peerage.
     *
     * @param \App\User $user
     * @param $peerage_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePeerage(User $user, $peerage_id)
    {
        $user->deletePeerage($peerage_id);

        return Redirect::route('home')->with('message', 'Peerage deleted');
    }

    /**
     * Process AJAX request to add or edit a note.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addOrEditNote(User $user)
    {
        $data = \Request::all();

        $msg = 'Note added';

        $user->note = $data['note_text'];

        $this->writeAuditTrail(
            (string) Auth::user()->id,
            'update',
            'users',
            (string) $user->id,
            $user->toJson(),
            'UserController@addOrEditNote'
        );

        $user->save();

        return redirect()->to(URL::previous())->with('message', $msg);
    }

    /**
     * Show the find a user page.
     *
     * @param \App\User|null $user
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function find(User $user = null)
    {
        if (($redirect =
                $this->checkPermissions(
                    [
                        'EDIT_MEMBER',
                        'EDIT_GRADE',
                        'VIEW_MEMBERS',
                    ]
                )
            ) !== true
        ) {
            return $redirect;
        }

        return view('user.find', ['user' => $user]);
    }

    /**
     * Process AJAX request to add a permission to a user.
     *
     * @param \App\User $user
     * @param $perm
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function addPerm(User $user, $perm)
    {
        if (($redirect =
                $this->checkPermissions(['EDIT_MEMBER', 'EDIT_GRADE'])) !== true
        ) {
            return $redirect;
        }

        $user->updatePerms((array) $perm);

        Cache::flush();

        return redirect()->to(URL::previous())->with(
            'message',
            $perm.' permission has been given to '.$user->getFullName()
        );
    }

    /**
     * Process AJAX request to remove a permission from a user.
     *
     * @param \App\User $user
     * @param $perm
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function deletePerm(User $user, $perm)
    {
        if (($redirect =
                $this->checkPermissions(['EDIT_MEMBER', 'EDIT_GRADE'])) !== true
        ) {
            return $redirect;
        }

        $user->deletePerm($perm);

        Cache::flush();

        return redirect()->to(URL::previous())->with(
            'message',
            $perm.' permission has been removed from '.$user->getFullName()
        );
    }

    /**
     * Show all members for the specified branch.
     *
     * @param $branch
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showBranch($branch)
    {
        if (($redirect = $this->checkPermissions('VIEW_'.strtoupper($branch))) !== true) {
            return $redirect;
        }

        $title = $branch.' Members';

        if ($branch == 'Bosun') {
            $title = 'Bosun List';
        }

        return view(
            'user.byBranch',
            [
                'title'  => $title,
                'branch' => $branch,
            ]
        );
    }

    /**
     * Show Ribbon Rack builder page.
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function buildRibbonRack(User $user = null)
    {
        if (($redirect =
                $this->checkPermissions(['EDIT_SELF', 'EDIT_RR'], true)) !== true
        ) {
            return $redirect;
        }

        if (isset($user->member_id) === false ||
            (isset($user->member_id) === true && Auth::user()->hasPermissions(['EDIT_RR'], true) === false)) {
            $user = Auth::user();
        }

        // Try and find unit patches for all of the users assignments
        $unitPatchPaths = [];
        foreach (['primary', 'secondary', 'additional', 'extra'] as $position) {
            $path = Auth::user()->getUnitPatchPath($position);

            if ($path !== false) {
                $unitPatchPaths[$path] = Auth::user()->getAssignmentName($position);
            }
        }

        $user->awards = $user->getCurrentAwards();

        return view(
            'user.rack',
            [
                'user'           => $user,
                'unitPatchPaths' => $unitPatchPaths,
                'restricted'     => MedusaConfig::get(
                    'awards.restricted',
                    ['OSWP', 'ESWP', 'MCAM']
                ),
                'wings'          => MedusaConfig::get(
                    'awards.wings',
                    [
                    'Aerospace Wings' => [
                        'EAW',
                        'OAW',
                        'ESAW',
                        'OSAW',
                        'EMAW',
                        'OMAW',
                    ],
                    'Navigator Wings' => [
                        'ENW',
                        'ONW',
                        'ESNW',
                        'OSNW',
                        'EMNW',
                        'OMNW',
                    ],
                    'Observer Wings'  => [
                        'EOW',
                        'OOW',
                        'ESOW',
                        'OSOW',
                        'EMOW',
                        'OMOW',
                    ],
                    'Simulator Wings' => [
                        'ESW',
                        'OSW',
                        'ESSW',
                        'OSSW',
                        'EMSW',
                        'OMSW',
                    ],
                    ]
                ),
            ]
        );
    }

    /**
     * Save the submitted ribbon rack.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveRibbonRack(User $user)
    {
        if (($redirect =
                $this->checkPermissions(['EDIT_SELF'])) !== true
        ) {
            return $redirect;
        }
        $data = \Request::all();

        // Process the display choice for qualification badges

        $displayChoice = MedusaConfig::get(
            'awards.display',
            [
                'OSWP',
                'ESWP',
                'SAW',
                'EAW',
                'OAW',
                'ESAW',
                'OSAW',
                'EMAW',
                'OMAW',
                'ENW',
                'ONW',
                'ESNW',
                'OSNW',
                'EMNW',
                'OMNW',
                'EOW',
                'OOW',
                'ESOW',
                'OSOW',
                'EMOW',
                'OMOW',
                'ESW',
                'OSW',
                'ESSW',
                'OSSW',
                'EMSW',
                'OMSW',
                'HS',
                'CIB',
            ]
        );

        foreach ($displayChoice as $qualBadge) {
            $data[$qualBadge.'_display'] = false;
        }

        if (empty($data['qualbadge_display']) === false) {
            $data[$data['qualbadge_display'].'_display'] = true;
        }

        // Process the groups

        $groups = Arr::where(
            $data,
            function ($value, $key) {
                return substr($key, 0, 5) == 'group';
            }
        );

        // Process the selects

        $selects = Arr::where(
            $data,
            function ($value, $key) {
                return substr($key, -4) == '_chk';
            }
        );

        foreach ($groups as $index => $award) {
            if ($index != $award) {
                $data['ribbon'][] = $award;

                if (array_key_exists($award.'_quantity', $data) === false) {
                    $data[$award.'_quantity'] = 1;
                }
            }
        }

        foreach ($selects as $key => $value) {
            if (is_string($value) === true && is_numeric($value) === false) {
                $award = json_decode($data[substr($key, 0, -4)]);
                $data['ribbon'][] = $award->code;
                $data[$award->code.'_quantity'] = 1;
            }
        }

        $curAwards = $user->awards;
        $awards = [];

        if (isset($data['ribbon']) === true) {
            foreach ($data['ribbon'] as $award) {
                if (empty($curAwards[$award]) === false) {
                    // Preserve all the valid dates
                    $awardDates =
                        $this->preserveValidDates($curAwards[$award]['award_date']);

                    asort($awardDates);

                    $numPending = $this->countPendingAwards($awardDates);

                    // If the number of awards specified is less than the current count, add in the number pending
                    if ($data[$award.'_quantity'] + $numPending <=
                        $curAwards[$award]['count']) {
                        $data[$award.'_quantity'] += $numPending;
                    }

                    // If we have more valid dates than the quantity, only take as many dates as we have awards
                    if (count($awardDates) > $data[$award.'_quantity']) {
                        $awardDates =
                            array_slice($awardDates, $data[$award.'_quantity']);
                    }

                    if ($data[$award.'_quantity'] > $curAwards[$award]['count']) {
                        // Number of award instances specified is greater than the current value
                        // Fill out the start of the array as needed
                        $awardDates = array_merge(
                            array_fill(
                                0,
                                $data[$award.'_quantity'] -
                                $curAwards[$award]['count'],
                                '1970-01-01'
                            ),
                            $awardDates
                        );
                    } elseif ($data[$award.'_quantity'] <
                              $curAwards[$award]['count']) {
                        // The number of award instances has been reduced
                        // Fill out the start of the array as needed
                        $awardDates = array_merge(
                            array_fill(
                                0,
                                $data[$award.'_quantity'] - count($awardDates),
                                '1970-01-01'
                            ),
                            $awardDates
                        );
                    } elseif (count($awardDates) < $data[$award.'_quantity']) {
                        $awardDates = array_merge(
                            array_fill(
                                0,
                                $data[$award.'_quantity'] - count($awardDates),
                                '1970-01-01'
                            ),
                            $awardDates
                        );
                    }
                } else {
                    $awardDates =
                        array_fill(0, $data[$award.'_quantity'], '1970-01-01');
                }

                $awards[$award] =
                    [
                        'count'      => $data[$award.'_quantity'],
                        'location'   => Award::where('code', '=', $award)
                                             ->first()->location,
                        'award_date' => $awardDates,
                        'display'    => isset($data[$award.'_display']) ?
                            $data[$award.'_display'] : true,
                    ];
            }
        }

        // Find out what awards are not present in the new list

        $notPresent = array_diff_key($curAwards, $awards);

        // Iterate through the not presents and see if we have any pending awards

        foreach ($notPresent as $code => $award) {
            $award['award_date'] =
                (array) $this->preserveFutureDates($award['award_date']);
            $award['count'] = $this->countPendingAwards($award['award_date']);

            if ($award['count'] > 0) {
                // We have a pending award, add it to the new list
                $awards[$code] = $award;
            }
        }

        $user->awards = $awards;

        if (empty($data['unitPatch']) === false) {
            $user->unitPatchPath = $data['unitPatch'];
        }

        if (empty($data['usePeerageLands']) === false) {
            $user->usePeerageLands = true;
        }

        if (empty($data['extraPadding']) === false) {
            $user->extraPadding = true;
        }

        $user->save();

        return redirect()->route('user.show', $user);
    }

    /**
     * Admin function to temporarily login as a user.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userSwitchStart(User $user)
    {
        Session::put('orig_user', Auth::id());
        Auth::login($user);
        event(new LoginComplete(Auth::user()));

        return back();
    }

    /**
     * Admin function to return to your original user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userSwitchStop()
    {
        $id = Session::pull('orig_user');
        Auth::login(User::find($id));

        return back();
    }

    /**
     * Process an array of dates formatted YYYY-MM-DD and return any that are not
     * 1970-01-01.
     *
     * @param array $dates
     *
     * @return array
     */
    private function preserveValidDates(array $dates)
    {
        return Arr::where(
            $dates,
            function ($value, $key) {
                return $value != '1970-01-01';
            }
        );
    }

    /**
     * Process an array of dates formatted YYYY-MM-DD and return any that are at
     * least 2 days in the future.
     *
     * @param array $dates
     *
     * @return array
     */
    private function preserveFutureDates(array $dates)
    {
        $today = Carbon::today('America/New_York');

        return Arr::where(
            $dates,
            function ($value, $key) use ($today) {
                return $today->lt(Carbon::createFromFormat('Y-m-d H', $value.' 0')->addDays(config('awards.display_days')));
            }
        );
    }

    /**
     * Count the number of awards that are pending.
     *
     * @param array $awardDates
     *
     * @return int
     */
    private function countPendingAwards(array $awardDates)
    {
        $numPending = 0;
        $today = Carbon::today('America/New_York');

        // Count the number of awards that are in the future
        foreach ($awardDates as $date) {
            if ($today->lt(Carbon::createFromFormat('Y-m-d H', $date.' 0')->addDays(config('awards.display_days')))) {
                $numPending++;
            }
        }

        return $numPending;
    }

    /**
     * Update a members promotion points.
     *
     * @param \Illuminate\Http\Request $request
     * @param $user
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function updatePoints(\Illuminate\Http\Request $request, $user)
    {
        if (($redirect =
                $this->checkPermissions(['EDIT_MEMBER', 'EDIT_SELF'])) !== true
        ) {
            return $redirect;
        }

        $points = [];

        foreach ($request->points as $key => $value) {
            $points[$key] = $value >= 0 ? $value : 0;
        }

        $user->points = $points;

        try {
            $user->save();

            $this->writeAuditTrail(
                (string) Auth::user()->id,
                'update',
                'users',
                (string) $user->id,
                json_encode($user->points),
                'UserController@updatePoints'
            );
        } catch (\Exception $d) {
            return redirect()->to('/user/'.$user->id)->with(
                'error',
                'There was a problem saving your changes.'
            );
        }

        Cache::flush();

        return redirect()->to('/user/'.$user->id)->with(
            'status',
            'Your promotion points have been updated.'
        );
    }
}
