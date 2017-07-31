<?php

namespace App\Http\Controllers;

use App\Award;
use App\Billet;
use App\Branch;
use App\Chapter;
use App\Country;
use App\Events\EmailChanged;
use App\Grade;
use App\Korders;
use App\MedusaConfig;
use App\Ptitles;
use App\Rating;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

use Webpatser\Countries\Countries;

class UserController extends Controller
{

    /**
     * Display a listing of users
     *
     * @return Response
     */
    public function index()
    {
        if (($redirect = $this->checkPermissions('VIEW_MEMBERS')) !== true) {
            return $redirect;
        }

        $branches =
            ['RMN', 'RMMC', 'RMA', 'GSN', 'RHN', 'IAN', 'SFS', 'CIVIL', 'INTEL'];

        foreach ($branches as $branch) {
            $users = User::where('active', '=', 1)
                ->where('registration_status', '=', 'Active')
                ->where('branch', '=', $branch)
                ->get();

            $usersByBranch[$branch] = $users;
        }

        $usersOtherThanActive = [];

        foreach (User::whereIn(
            'registration_status',
            ['Inactive', 'Suspended', 'Expelled']
        )->get() as $user) {
            $usersOtherThanActive[$user->registration_status][] = $user;
        }

        return view(
            'user.index',
            [
                'users' => $usersByBranch,
                'title' => 'Membership List',
                'otherThanActive' => $usersOtherThanActive,
                'totalMembers' => User::where(
                    'registration_status',
                    '=',
                    'Active'
                )->where('active', '=', 1)->count(),
                'totalEnlisted' => User::where(
                    'registration_status',
                    '=',
                    'Active'
                )->where('active', '=', 1)->where(
                    'rank.grade',
                    'like',
                    'E%'
                )->count(),
                'totalOfficer' => User::where(
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
                'totalCivilian' => User::where(
                    'registration_status',
                    '=',
                    'Active'
                )->where('active', '=', 1)->where(
                    'rank.grade',
                    'like',
                    'C%'
                )->count()
            ]
        );
    }

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
            ['users' => $users, 'title' => 'Show ' . $billet]
        );
    }

    public function getReset(User $user)
    {
        return view('user.reset', ['user' => $user]);
    }

    public function postReset(User $user)
    {
        $in =
            Request::only([
                'current_password',
                'password',
                'password_confirmation'
            ]);

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
                (string)Auth::user()->_id,
                'update',
                'users',
                (string)$user->_id,
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

    public function reviewApplications()
    {
        if (($redirect =
                $this->checkPermissions('PROC_APPLICATIONS')) !== true
        ) {
            return $redirect;
        }

        $users =
            User::where('active', '!=', "1")
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

    public function approveApplication(User $user)
    {
        if (($redirect =
                $this->checkPermissions('PROC_APPLICATIONS')) !== true
        ) {
            return $redirect;
        }

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
        $user->member_id = 'RMN' . User::getFirstAvailableMemberId();

        $user->permissions = [
            'LOGOUT',
            'CHANGE_PWD',
            'EDIT_SELF',
            'ROSTER',
            'TRANSFER'
        ];

        $user->lastUpdate = time();

        $this->writeAuditTrail(
            (string)Auth::user()->_id,
            'update',
            'users',
            (string)$user->_id,
            $user->toJson(),
            'UserController@approveApplication'
        );

        $user->save();

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
            (string)Auth::user()->_id,
            'update',
            'users',
            (string)$user->_id,
            $user->toJson(),
            'UserController@denyApplication'
        );

        $user->save();

        return Redirect::route('user.review');
    }

    /**
     * Show the form for creating a new user
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
                'user' => new User,
                'countries' => Country::getCountries(),
                'branches' => Branch::getBranchList(),
                'grades' => Grade::getGradesForBranch('RMN'),
                'ratings' => Rating::getRatingsForBranch('RMN'),
                'chapters' => ['' => 'Start typing to search for a chapter'] + Chapter::getFullChapterList(),
                'billets' => ['' => 'Select a Billet'] + Billet::getBillets(),
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
            'grade' => $data['display_rank'],
            'date_of_rank' => date(
                'Y-m-d',
                strtotime($data['dor'])
            )
        ];
        unset($data['display_rank'], $data['dor']);

        // Build up the member assignments

        $chapterName = Chapter::find($data['primary_assignment'])->chapter_name;

        $assignment[] = [
            'chapter_id' => $data['primary_assignment'],
            'chapter_name' => $chapterName,
            'date_assigned' => date(
                'Y-m-d',
                strtotime($data['primary_date_assigned'])
            ),
            'billet' => $data['primary_billet'],
            'primary' => true
        ];

        unset($data['primary_assignment'], $data['primary_date_assigned'], $data['primary_billet']);

        if (isset($data['secondary_assignment']) === true && empty($data['secondary_assignment']) === false) {
            $chapterName =
                Chapter::find($data['secondary_assignment'])->chapter_name;

            $assignment[] = [
                'chapter_id' => $data['secondary_assignment'],
                'chapter_name' => $chapterName,
                'date_assigned' => date(
                    'Y-m-d',
                    strtotime($data['secondary_date_assigned'])
                ),
                'billet' => $data['secondary_billet'],
                'secondary' => true
            ];
        }

        unset($data['secondary_assignment'], $data['secondary_date_assigned'], $data['secondary_billet']);

        $data['assignment'] = $assignment;

        // Hash the password

        $data['password'] = Hash::make($data['password']);

        // Assign a member id

        $data['member_id'] =
            'RMN' . User::getFirstAvailableMemberId(empty($data['honorary']));

        if (isset($data['honorary']) === true && $data['honorary'] === "1") {
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
            'TRANSFER'
        ];

        // For future use

        $data['peerage_record'] = [];

        $data['awards'] = [];

        unset($data['_token'], $data['password_confirmation']);

        $data['email_address'] = strtolower($data['email_address']);

        $data['lastUpdate'] = time();

        $this->writeAuditTrail(
            (string)Auth::user()->_id,
            'create',
            'users',
            null,
            json_encode($data),
            'UserController@store'
        );

        $user = User::create($data);

        // Until I figure out why mongo drops fields, I'm doing this hack!

        $u = User::find($user['_id']);

        foreach ($data as $key => $value) {
            $u->$key = $value;
        }

        $u->save();

        Event::fire('user.created', $user);

        return Redirect::route('user.index');
    }

    /**
     * Store a new applicant
     *
     * @return Response
     */
    public function apply()
    {
        $rules = [
            'email_address' => 'required|email|unique:users',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'address1' => 'required|min:4',
            'city' => 'required|min:2',
            'state_province' => 'required|min:2',
            'postal_code' => 'required|min:2',
            'country' => 'required|min:2',
            'password' => 'required|confirmed',
            'dob' => 'required|date|date_format:Y-m-d',
            'branch' => 'required',
            'primary_assignment' => 'required|min:2',
            'tos' => 'required',
        ];

        $error_message = [
            'first_name.required' => 'Please enter your first name',
            'first_name.min' => 'Your first name must be at least 2 characters long',
            'last_name.required' => 'Please enter your last name',
            'last_name.min' => 'Your last name must be at least 2 characters long',
            'address1.required' => 'Please enter your street address',
            'address1.min' => 'The street address must be at least 4 characters long',
            'city.required' => 'Please enter your city',
            'city.min' => 'Your city must be at least 2 characters long',
            'state_province.required' => 'Please enter your state or province',
            'state_province.min' => 'Your state or province must be at least 2 characters long',
            'postal_code.required' => 'Please enter your zip or postal code',
            'postal_code.min' => 'Your zip or postal code must be at least 2 characters long',
            'country.required' => 'Please enter your country',
            'country.min' => 'Your country must be at least 2 characters long',
            'dob.required' => 'Please enter your date of birth',
            'dob.date_format' => 'Please enter your date of birth in the YYYY-MM-DD format',
            'dob.date' => 'Please enter a valid date of birth',
            'primary_assignment.required' => "Please select a chapter",
            'primary_assignment.min' => "Please select a chapter",
            'branch.required' => "Please select the members branch",
            'email_address.unique' => 'That email address is already in use',
            'email_address.required' => 'Please enter your email address',
            'tos.required' => 'You must agree to the Terms of Service to apply',
        ];

        $data = \Request::all();

        if (isset($data['mobile']) === false) {
            $validator = Validator::make($data, $rules, $error_message);

            if ($validator->fails()) {
                return redirect('register')
                    ->withErrors($validator)
                    ->withInput();
            }

            // Check Captcha
            $secret = '6LdcghoTAAAAAJsX2nfOdCPvrCLc902o5ohewlyq';
            $captcha = \Request::get('g-recaptcha-response', null);

            if (empty($captcha) === false) {
                $recaptcha = new \ReCaptcha\ReCaptcha($secret);

                $resp = $recaptcha->verify($captcha, $_SERVER['REMOTE_ADDR']);

                if ($resp->isSuccess() === false) {
                    return redirect('register')
                        ->withErrors(['message' => 'Please prove that you\'re a sentient being'])
                        ->withInput();
                }
            } else {
                return redirect('register')
                    ->withErrors(['message' => 'Please prove that you\'re a sentient being'])
                    ->withInput();
            }
        }

        $data['rank'] = ['grade' => 'E-1', 'date_of_rank' => date('Y-m-d')];

        switch ($data['branch']) {
            case "CIVIL":
            case "INTEL":
                $data['rank']['grade'] = 'C-1';
                $billet = "Civilian One";
                break;
            case "SFS":
                $data['rank']['grade'] = 'C-1';
                $billet = "Cadet Ranger One";
                break;
            case "RMMM":
                $data['rank']['grade'] = 'C-1';
                $billet = "Apprentice Merchant Spacer";
                break;
            case "RMACS":
                $data['rank']['grade'] = 'C-1';
                $billet = "Trainee";
                break;
            case "RMMC":
                $billet = "Marine";
                break;
            case "RMA":
                $billet = "Soldier";
                break;
            default:
                $billet = "Crewman";
        }

        if (isset($data['primary_assignment']) === true && empty($data['primary_assignment']) === false) {
            $chapterName =
                Chapter::find($data['primary_assignment'])->chapter_name;

            $data['assignment'][] = [
                'chapter_id' => $data['primary_assignment'],
                'chapter_name' => $chapterName,
                'date_assigned' => date('Y-m-d'),
                'billet' => $billet,
                'primary' => true
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

        $data['peerage_record'] = [];
        $data['awards'] = [];
        $data['active'] = 0;
        $data['application_date'] = date('Y-m-d');
        $data['registration_status'] = 'Pending';

        unset($data['_token'], $data['password_confirmation']);

        $data['email_address'] = strtolower($data['email_address']);

        asort($data);

        $data['lastUpdate'] = time();

        $this->writeAuditTrail(
            'Guest from ' . \Request::getClientIp(),
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
                return Response::json([
                    'status' => 'error',
                    'message' => 'Unable to create user',
                ], 500);
            } else {
                return Response::json([
                    'status' => 'success',
                    'message' => 'User created',
                ]);
            }
        } else {
            return view('thankyou');
        }
    }

    /**
     * Display the specified user.
     *
     * @param  User $user
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
            $this->hasPermissions([
                'VIEW_MEMBERS',
                'VIEW_' . $user->branch
            ]) === false
        ) {
            return redirect(URL::previous())
                ->with(
                    'message',
                    'You do not have permission to view that page'
                );
        }

        $titles[''] = 'Select Peerage Title';

        foreach (Ptitles::orderBy('precedence')->get() as $title) {
            $titles[$title->title] = $title->title;
        }

        $orders[''] = 'Select Order';

        foreach (Korders::all() as $order) {
            $orders[$order->id] = $order->order;
        }

        $user->leftRibbonCount = count($user->getRibbons('L'));
        $user->leftRibbons = $user->getRibbons('L');
        $user->numAcross = 3;

        return view(
            'user.show',
            [
                'user' => $user,
                'countries' => Country::getCountries(),
                'branches' => Branch::getBranchList(),
                'ptitles' => $titles,
                'korders' => $orders,
                'message' => $message,
            ]
        );
    }

    public function fullRibbonDisplay(User $user)
    {
        if ($this->isInChainOfCommand($user) === false &&
            Auth::user()->id != $user->id &&
            $this->hasPermissions([
                'VIEW_MEMBERS',
                'VIEW_' . $user->branch
            ]) === false
        ) {
            return redirect(URL::previous())
                ->with(
                    'message',
                    'You do not have permission to view that page'
                );
        }

        $user->leftRibbonCount = count($user->getRibbons('L'));
        $user->leftRibbons = $user->getRibbons('L');

        return view('user.bib', ['user' => $user,]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  User $user
     *
     * @return Response
     */
    public function edit(User $user)
    {
        if (($this->hasPermissions(['EDIT_SELF']) === true && Auth::user()->id == $user->id) || $this->hasPermissions(
                ['EDIT_MEMBER']
            ) === true
        ) {
            $greeting = $user->getGreetingArray();

            if (isset($user->rating) === true && empty($user->rating) === false && is_array(
                    $user->rating
                ) === false
            ) {
                $user->rating =
                    [
                        'rate' => $user->rating,
                        'description' => Rating::where(
                            'rate_code',
                            '=',
                            $user->rating
                        )->get()[0]->rate['description']
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
                    'TRANSFER'
                ];
            }

//            $chapters = ;
            return view(
                'user.edit',
                [
                    'user' => $user,
                    'greeting' => $greeting,
                    'countries' => Country::getCountries(),
                    'branches' => Branch::getBranchList(),
                    'grades' => Grade::getGradesForBranch($user->branch),
                    'ratings' => Rating::getRatingsForBranch($user->branch),
                    'chapters' => $user->hasPermissions(['EDIT_MEMBER']) === true ? ['' => 'Start typing to search for a chapter'] + Chapter::getFullChapterList() : Chapter::getChapters(null,
                        0, false),
                    'billets' => ['' => 'Select a billet'] + Billet::getBillets(),
                    'locations' => ['' => 'Select a Location'] + Chapter::getChapterLocations(),
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
     * @param  User $user
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

        // Massage the data a little bit.  First, build up the rank array

        $rank = [];

        if (isset($data['display_rank']) === true && empty($data['display_rank']) === false) {
            $data['rank'] = ['grade' => $data['display_rank']];

            if (empty($data['dor']) === true) {
                $data['rank']['date_of_rank'] = '';
            } else {
                $data['rank']['date_of_rank'] =
                    date('Y-m-d', strtotime($data['dor']));
            }
            unset($data['display_rank'], $data['dor']);
        }

        // Build up the member assignments

        $chapterName = Chapter::find($data['primary_assignment'])->chapter_name;

        $assignment[] = [
            'chapter_id' => $data['primary_assignment'],
            'chapter_name' => $chapterName,
            'date_assigned' => date(
                'Y-m-d',
                strtotime($data['primary_date_assigned'])
            ),
            'billet' => $data['primary_billet'],
            'primary' => true
        ];

        unset($data['primary_assignment'], $data['primary_date_assigned'], $data['primary_billet']);

        if (isset($data['secondary_assignment']) === true && empty($data['secondary_assignment']) === false) {
            $chapterName =
                Chapter::find($data['secondary_assignment'])->chapter_name;

            $assignment[] = [
                'chapter_id' => $data['secondary_assignment'],
                'chapter_name' => $chapterName,
                'date_assigned' => date(
                    'Y-m-d',
                    strtotime($data['secondary_date_assigned'])
                ),
                'billet' => $data['secondary_billet'],
                'secondary' => true
            ];

            unset($data['secondary_assignment'], $data['secondary_date_assigned'], $data['secondary_billet']);
        }

        if (isset($data['additional_assignment']) === true && empty($data['additional_assignment']) === false) {
            $chapterName =
                Chapter::find($data['additional_assignment'])->chapter_name;

            $assignment[] = [
                'chapter_id' => $data['additional_assignment'],
                'chapter_name' => $chapterName,
                'date_assigned' => date(
                    'Y-m-d',
                    strtotime($data['additional_date_assigned'])
                ),
                'billet' => $data['additional_billet'],
                'additional' => true
            ];

            unset($data['additional_assignment'], $data['additional_date_assigned'], $data['additional_billet']);
        }

        if (isset($data['extra_assignment']) === true && empty($data['extra_assignment']) === false) {
            $chapterName =
                Chapter::find($data['extra_assignment'])->chapter_name;

            $assignment[] = [
                'chapter_id' => $data['extra_assignment'],
                'chapter_name' => $chapterName,
                'date_assigned' => date(
                    'Y-m-d',
                    strtotime($data['extra_date_assigned'])
                ),
                'billet' => $data['extra_billet'],
                'extra' => true
            ];

            unset($data['extra_assignment'], $data['extra_date_assigned'], $data['extra_billet']);
        }

        $data['assignment'] = $assignment;

        if (isset($data['password']) === true && empty($data['password']) === false) {
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

            if ($data['reload_form'] === "yes") {
                return Redirect::route('user.edit', [$user->_id]);
            }

            Cache::flush();

            $this->writeAuditTrail(
                (string)Auth::user()->_id,
                'update',
                'users',
                (string)$user->_id,
                json_encode($data),
                'UserController@update'
            );

            event(new EmailChanged($oldEmail, $data['email_address']));

            return redirect($data['redirectTo']);
        } catch (\Exception $d) {
            return redirect()->to('/user/' . $user->id)->with('error', 'There was a problem saving your changes.');
        }

    }

    public function tos()
    {
        $this->loginValid();

        $data = \Request::all();

        if (empty($data['tos']) === false) {
            $user = User::find($data['id']);
            $user->tos = true;

            $this->writeAuditTrail(
                (string)Auth::user()->_id,
                'update',
                'users',
                (string)$user->_id,
                $user->toJson(),
                'UserController@tos'
            );

            $user->save();

            return redirect()->to(session('url.intended'));
        }

        return redirect()->to('signout');
    }

    public function osa()
    {
        $this->loginValid();

        $data = \Request::all();

        if (empty($data['osa']) === false) {
            $user = User::find($data['id']);
            $user->osa = date('Y-m-d');

            $this->writeAuditTrail(
                (string)Auth::user()->_id,
                'update',
                'users',
                (string)$user->_id,
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
     * @param  User $user
     *
     * @return Response
     */
    public function confirmDelete(User $user)
    {
        if (($redirect = $this->checkPermissions('DEL_MEMBER')) !== true) {
            return $redirect;
        }

        return view('user.confirm-delete', ['user' => $user,]);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  User $user
     *
     * @return Response
     */
    public function destroy(User $user)
    {
        if (($redirect = $this->checkPermissions('DEL_MEMBER')) !== true) {
            return $redirect;
        }

        $this->writeAuditTrail(
            (string)Auth::user()->_id,
            'hard delete',
            'users',
            (string)$user->_id,
            $user->toJson(),
            'UserController@destroy'
        );

        User::destroy($user->_id);

        Cache::flush();

        return Redirect::route('user.index');
    }

    public function register()
    {
        $fullBranchList = Branch::all();
        $branches = [];

        foreach ($fullBranchList as $branch) {
            $branches[$branch['branch']] = $branch['branch_name'];
        }

        asort($branches);

        $viewData = [
            'user' => new User,
            'countries' => Country::getCountries(),
            'branches' => $branches,
            'chapters' => ['' => 'Start typing to search for a chapter'] + Chapter::getFullChapterList(),
            'locations' => ['' => 'Select a Location'] + Chapter::getChapterLocations(),
            'register' => true,
        ];

        return view('user.register', $viewData);
    }

    private function _getCountries()
    {
        $results = Countries::getList();
        $countries = [];

        foreach ($results as $country) {
            $countries[$country['iso_3166_3']] = $country['name'];
        }

        asort($countries);

        return $countries;
    }

    private function _buildPeerageRecord($data)
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
                $kOrder->getPrecedence([
                    'type' => 'postnominal',
                    'value' => $data['class']
                ]);
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

    public function addOrEditPeerage(User $user)
    {
        $data = \Request::all();

        $msg = "Peerage added";

        if (empty($data['peerage_id']) === false) {
            // This is an edit
            $user->deletePeerage($data['peerage_id']);
            $msg = "Peerage updated";
        }

        $peerage = $this->_buildPeerageRecord($data);

        if (empty($data['filename']) === false && empty($peerage['filename']) === true) {
            // Peerage entry had a file name set.  No new image uploaded
            $peerage['filename'] = $data['filename'];
        }

        $currentPeerages = $user->peerages;
        $currentPeerages[] = $peerage;

        $user->peerages = $currentPeerages;

        $this->writeAuditTrail(
            (string)Auth::user()->_id,
            'update',
            'users',
            (string)$user->_id,
            $user->toJson(),
            'UserController@addOrEditPeerage'
        );

        $user->save();

        return redirect()->to(URL::previous())->with('message', $msg);
    }

    public function deletePeerage(User $user, $peerageId)
    {
        $user->deletePeerage($peerageId);

        return Redirect::route('home')->with('message', 'Peerage deleted');
    }

    public function addOrEditNote(User $user)
    {
        $data = \Request::all();

        $msg = "Note added";

        $user->note = $data['note_text'];

        $this->writeAuditTrail(
            (string)Auth::user()->_id,
            'update',
            'users',
            (string)$user->_id,
            $user->toJson(),
            'UserController@addOrEditNote'
        );

        $user->save();

        return redirect()->to(URL::previous())->with('message', $msg);
    }

    public function find(User $user = null)
    {
        if (($redirect =
                $this->checkPermissions([
                    'EDIT_MEMBER',
                    'EDIT_GRADE',
                    'VIEW_MEMBERS'
                ])) !== true
        ) {
            return $redirect;
        }

        return view('user.find', ['user' => $user]);
    }

    public function addPerm(User $user, $perm)
    {
        if (($redirect =
                $this->checkPermissions(['EDIT_MEMBER', 'EDIT_GRADE'])) !== true
        ) {
            return $redirect;
        }

        $user->updatePerms((array)$perm);

        Cache::flush();

        return redirect()->to(URL::previous())->with(
            'message',
            $perm . ' permission has been given to ' . $user->getFullName()
        );
    }

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
            $perm . ' permission has been removed from ' . $user->getFullName()
        );
    }

    public function showBranch($branch)
    {
        if (($redirect = $this->checkPermissions('VIEW_' . $branch)) !== true) {
            return $redirect;
        }

        $users = User::where('active', '=', 1)
            ->where('registration_status', '=', 'Active')
            ->where('branch', '=', $branch)
            ->get();

        $usersByBranch[$branch] = $users;

        return view(
            'user.byBranch',
            [
                'users' => $usersByBranch,
                'title' => $branch . " Members",
                'branch' => $branch
            ]
        );
    }

    public function buildRibbonRack()
    {
        if (($redirect =
                $this->checkPermissions(['EDIT_SELF'])) !== true
        ) {
            return $redirect;
        }

        // Try and find unit patches for all of the users assignments
        $unitPatchPaths = [];
        foreach (['primary', 'secondary', 'additional', 'extra'] as $position) {
            $path = Auth::user()->getUnitPatchPath($position);

            if ($path !== false) {
                $unitPatchPaths[$path] = Auth::user()->getAssignmentName($position);
            }
        }

        return view('user.rack',
            ['user' => Auth::user(), 'unitPatchPaths' => $unitPatchPaths]);
    }

    public function saveRibbonRack()
    {
        if (($redirect =
                $this->checkPermissions(['EDIT_SELF'])) !== true
        ) {
            return $redirect;
        }
        $data = \Request::all();

        $groups = array_where($data, function ($value, $key) {
            return substr($key, 0, 5) == 'group';
        });

        $selects = array_where($data, function ($value, $key) {
            return substr($key, -4) == '_chk';
        });

        foreach ($groups as $index => $award) {
            if ($index != $award) {
                $data['ribbon'][] = $award;

                if (key_exists($award . '_quantity', $data) === false) {
                    $data[$award . '_quantity'] = 1;
                }
            }
        }

        foreach ($selects as $key => $value) {
            if (is_string($value) === true && is_numeric($value) === false) {
                $award = json_decode($data[substr($key, 0, -4)]);
                $data['ribbon'][] = $award->code;
                $data[$award->code . '_quantity'] = 1;
            }
        }

        $awards = [];

        if (isset($data['ribbon']) === true) {
            foreach ($data['ribbon'] as $award) {
                $awards[$award] =
                    [
                        'count' => $data[$award . '_quantity'],
                        'location' => Award::where('code', '=', $award)
                            ->first()->location
                    ];
            }
        }

        Auth::user()->awards = $awards;

        if (empty($data['unitPatch']) === false) {
            Auth::user()->unitPatchPath = $data['unitPatch'];
        }

        if (empty($data['usePeerageLands']) === false) {
            Auth::user()->usePeerageLands = true;
        }

        if (empty($data['extraPadding']) === false) {
            Auth::user()->extraPadding = true;
        }

        Auth::user()->save();

        return redirect()->to('home');
    }
}
