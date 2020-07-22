<?php

namespace App\Http\Controllers;

use App\Award;
use App\Branch;
use App\Chapter;
use App\ExamList;
use App\Grade;
use App\Korders;
use App\MedusaConfig;
use App\Rating;
use App\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Webpatser\Countries\Countries;

class ApiController extends Controller
{
    public function getBranchList()
    {
        return Response::json(Branch::getEnhancedBranchList(['include_rmmm_divisions' => false]));
    }

    public function getEnhancedBranchList()
    {
        return Response::json(Branch::getEnhancedBranchList());
    }

    public function getCountries()
    {
        $countryModel = new Countries();
        $results = $countryModel->getList();

        $countries = [];

        foreach ($results as $country) {
            $countries[$country['iso_3166_3']] = $country['name'];
        }

        asort($countries);

        $countries = ['' => 'Select a Country'] + $countries;

        return Response::json($countries);
    }

    public function getGradesForBranch($branchID)
    {
        return Response::json(Grade::getGradesForBranch($branchID));
    }

    public function getGradesForRating($rating, $branch)
    {
        $ratings = Rating::where('rate_code', $rating)->first();

        $ratingsForBranch = $ratings->rate[$branch];
        ksort($ratingsForBranch, SORT_NATURAL);

        return [$ratings->rate['description'] => $this->parseRatingsForBranch($ratingsForBranch)];
    }

    private function parseRatingsForBranch($ratings)
    {
        $grades = [];

        foreach ($ratings as $grade => $rate) {
            $grades[$grade] = $this->mbTrim($rate).' ('.$grade.')';
        }

        return $grades;
    }

    /**
     * Trim whitespace from mb_strings.
     *
     * @param $string
     * @param string $trim_chars
     *
     * @return mixed
     */
    private function mbTrim($string, $trim_chars = '\s')
    {
        return preg_replace('/^['.$trim_chars.']*(?U)(.*)['.$trim_chars.']*$/u', '\\1', $string);
    }

    public function getChapters()
    {
        return Response::json(Chapter::getChapters());
    }

    public function getChaptersByBranch($branchID, $location = 0)
    {
        return Response::json(Chapter::getChapters($branchID, $location));
    }

    public function getRatingsForBranch($branchID)
    {
        return Response::json(Rating::getRatingsForBranch($branchID));
    }

    public function getChapterLocations()
    {
        return Response::json(Chapter::getChapterLocations());
    }

    public function getHoldingChapters()
    {
        return Response::json(Chapter::getHoldingChapters());
    }

    public function getFleets()
    {
        return Response::json(Chapter::getChaptersByType('fleet'));
    }

    public function getHeadquarters()
    {
        return Response::json(Chapter::getChaptersByType('headquarters'));
    }

    public function getBureaus()
    {
        return Response::json(Chapter::getChaptersByType('bureau'));
    }

    public function getSeparationUnits()
    {
        return Response::json(Chapter::getChaptersByType('SU'));
    }

    public function getTaskForces()
    {
        return Response::json(Chapter::getChaptersByType('task_force'));
    }

    public function getTaskGroups()
    {
        return Response::json(Chapter::getChaptersByType('task_group'));
    }

    public function getSquadrons()
    {
        return Response::json(Chapter::getChaptersByType('squadron'));
    }

    public function getDivisions()
    {
        return Response::json(Chapter::getChaptersByType('division'));
    }

    public function getOffices()
    {
        return Response::json(Chapter::getChaptersByType('office'));
    }

    public function getAcademies()
    {
        return Response::json(Chapter::getChaptersByType('academy'));
    }

    public function getCenters()
    {
        return Response::json(Chapter::getChaptersByType('center'));
    }

    public function getColleges()
    {
        return Response::json(Chapter::getChaptersByType('college'));
    }

    public function getInstitutes()
    {
        return Response::json(Chapter::getChaptersByType('institute'));
    }

    public function getUniversities()
    {
        return Response::json(
            Chapter::getChaptersByType('university') +
            Chapter::getChaptersByType('university_system')
        );
    }

    public function checkAddress($email_address)
    {
        $user = User::where('email_address', '=', $email_address)->first();

        if (empty($user) === true) {
            return Response::json(['available' => true]);
        }

        return Response::json(['available' => false]);
    }

    public function savePhoto()
    {
        if (\Request::file('file')->isValid() === true) {
            $user =
                User::where('member_id', '=', \Request::get('member_id'))->first();

            $ext = \Request::file('file')->getClientOriginalExtension();
            $fileName = $user->member_id.'.'.$ext;

            \Request::file('file')->move(public_path().'/photos', $fileName);

            // File uploaded, add filename to user record
            $user->filePhoto = '/photos/'.$fileName;

            $this->writeAuditTrail(
                (string) \Auth::user()->id,
                'update',
                'users',
                (string) $user->_id,
                $user->toJson(),
                'ApiController@savePhoto'
            );

            $user->save();

            \Artisan::call('view:clear');
            \Artisan::call('cache:clear');
            \Artisan::call('route:clear');
        }
    }

    public function getKnightClasses($orderId)
    {
        $classes = [];

        if (empty($order = Korders::find($orderId)) === false) {
            foreach ($order->classes as $class) {
                $classes[$class['postnominal']] = $class['class'];
            }
        }

        return Response::json($classes);
    }

    public function findMember($query = null)
    {
        if (empty($query) === true) {
            $query = Request::get('query', null);
        }

        if (is_null($query) === true) {
            return Response::json(['suggestions' => []]);
        }

        $terms = explode(' ', $query);

        switch (count($terms)) {
            case 1:
                $query =
                    User::where('registration_status', '=', 'Active')
                        ->where(
                            function ($query) use ($terms) {
                                $query->where(
                                    'member_id',
                                    'like',
                                    '%'.$terms[0].'%'
                                )
                                    ->orWhere(
                                        'first_name',
                                        'like',
                                        $terms[0].'%'
                                    )
                                    ->orWhere(
                                        'last_name',
                                        'like',
                                        $terms[0].'%'
                                    );
                            }
                        );
                break;
            case 2:
                $query =
                    User::where('first_name', 'like', $terms[0].'%')
                        ->where('last_name', 'like', $terms[1].'%')
                        ->where('registration_status', '=', 'Active');
                break;
            default:
                $query =
                    User::where('first_name', 'like', $terms[0].'%')
                        ->where('middle_name', 'like', $terms[1].'%')
                        ->where('last_name', 'like', $terms[2].'%')
                        ->where('registration_status', '=', 'Active');
        }

        $results = $query->get();

        $suggestions = [];

        foreach ($results as $member) {
            $suggestions[] =
                [
                    'value' => $member->member_id.' '.$member->first_name.' '.
                        (! empty($member->middle_name) ?
                            $member->middle_name.' ' : '').
                        $member->last_name.
                        (! empty($member->suffix) ? ' '.$member->suffix :
                            '').' ('.$member->getAssignmentName(
                            'primary'
                        ).')',
                    'data' => $member->id,
                ];
        }

        return Response::json(['suggestions' => $suggestions]);
    }

    public function findChapter($query = null)
    {
        if (empty($query) === true) {
            $query = Request::get('query', null);
        }

        if (is_null($query) === true) {
            return Response::json(['suggestions' => []]);
        }

        $results =
            Chapter::orderBy('chapter_name', 'asc')
                ->where('chapter_name', 'like', '%'.$query.'%')
                ->whereNull('decommission_date')
                ->get();

        $suggestions = [];

        foreach ($results as $chapter) {
            $suggestions[] =
                [
                    'value' => $chapter->chapter_name,
                    'data' => $chapter->id,
                ];
        }

        return Response::json(['suggestions' => $suggestions]);
    }

    public function findExam()
    {
        $query = Request::get('query', null);

        if (is_null($query) === true) {
            return Response::json(['suggestions' => []]);
        }

        $results =
            ExamList::where('name', 'like', '%'.$query.'%')
                ->orWhere('exam_id', 'like', '%'.$query.'%')
                ->get();

        $suggestions = [];

        foreach ($results as $exam) {
            if ($exam->enabled === true) {
                $suggestions[] =
                    [
                        'value' => $exam->name.' ('.$exam->exam_id.')',
                        'data' => $exam->exam_id,
                    ];
            }
        }

        return Response::json(['suggestions' => $suggestions]);
    }

    public function getScheduledEvents($user, $continent = null, $city = null)
    {
        return Response::json(
            [
                'events' => $user->getScheduledEvents($continent, $city),
            ]
        );
    }

    public function checkInMember($event, $user, $member, $continent = null, $city = null)
    {
        if (is_object($user) === false) {
            return Response::json(['error' => 'Invalid User']);
        }

        return Response::json(
            $user->checkMemberIn(
                $event,
                $member,
                $continent,
                $city
            )
        );
    }

    public function getRibbonRack($member_id)
    {
        $user = User::where('member_id', '=', $member_id)->first();

        if (isset($user->awards) === true) {
            $user->leftRibbonCount = count($user->getRibbons('L'));
            $user->leftRibbons = $user->getRibbons('L');
            $user->numAcross = 3;

            if ($user->leftRibbonCount > 0) {
                if (Request::get('mobile', 'false') === 'true') {
                    return view('partials.leftribbons', ['user' => $user]);
                } else {
                    return view('ribbonrack', ['user' => $user]);
                }
            }

            return '';
        }
    }

    public function getChapterSelections()
    {
        return MedusaConfig::get(
            'chapter.selection',
            '[{"unjoinable": false, "label": "Holding Chapters", "url": "/api/holding"}]'
        );
    }

    public function setPath(\Illuminate\Http\Request $request)
    {
        try {
            $user = User::find($request->input('user_id'));

            $status = $user->setPath($request->input('path'));

            if ($status === true) {
                $user->addServiceHistoryEntry([
                    'timestamp' => time(),
                    'event' => ucfirst($request->input('path')).' path selected',
                ]);
            }

            return Response::json(['status' => $status === true ? 'ok' : 'error']);
        } catch (\Exception $e) {
            return Response::json(['status' => 'error']);
        }
    }

    public function updateAwardDisplayOrder(\Illuminate\Http\Request $request)
    {
        $awards = $request->all();

        $errors = 0;

        foreach ($awards as $award) {
            $res =
                Award::updateDisplayOrder($award['code'], $award['display_order']);

            if ($res === false) {
                $errors++;
            }
        }

        if ($errors > 0) {
            return Response::json(
                ['status' => 'error', 'msg' => 'There was a problem updating one or more awards']
            );
        } else {
            return Response::json(['status' => 'ok']);
        }
    }

    public function getPromotableInfo($id, $payGradeToCheck)
    {
        return Response::json(User::find($id)->getPromotableInfo($payGradeToCheck));
    }

    public function getPayGradesForUser($id)
    {
        $user = User::find($id);
        $rate = $user->getRate();

        if (is_null($rate) === true) {
            return Response::json(Grade::getGradesForBranch($user->branch));
        } else {
            return Response::json($this->getGradesForRating($rate, $user->branch));
        }
    }

    public function getBranchForUser($id)
    {
        $user = User::find($id);

        return Response::json(Branch::getBranchName($user->branch));
    }

    public function checkTransferRank($id, $newBranch)
    {
        $user = User::find($id);

        $branchInfo = Branch::where('branch', $user->branch)->first();

        if (isset($branchInfo->equivalent[$newBranch][$user->rank['grade']]) === true) {
            return 'Transferring from '.Branch::getBranchName($user->branch).' to '.
                Branch::getBranchName($newBranch).' will change the members rank from '.
                Grade::getRankTitle($user->rank['grade'], null, $user->branch).' ('.$user->rank['grade'].')'.
                ' to '.
                Grade::getRankTitle($branchInfo->equivalent[$newBranch][$user->rank['grade']], null, $newBranch).
                ' ('.$branchInfo->equivalent[$newBranch][$user->rank['grade']].')';
        } else {
            return 'Unable to determine the new rank for the member';
        }
    }

    public function checkRankQual(\Illuminate\Http\Request $request)
    {
        $member = User::getUserByMemberId($request->input('member_id'));
        $tigCheck = $request->input('tigCheck');
        $pointCheck = $request->input('ppCheck');
        $earlyPromotion = $request->input('ep');
        $payGrade2Check = $request->input('payGrade');
        $userPath = $request->input('path', null);
        $msg = null;

        if ($tigCheck === true) {
            $payGrade2Check =
                null; // If we're checking TiG, we want to look up the next paygrade
        }

        $promotionInfo = $member->getPromotableInfo($payGrade2Check, true, $userPath);

        $canPromote = $promotionInfo['exams']; // Always have to have the exams

        if ($promotionInfo['exams'] === false) {
            $msg[] =
                'The member does not have the required coursework for the rank selected.';
        }

        if ($pointCheck === true) {
            $canPromote = $canPromote && $promotionInfo['points'];

            if ($promotionInfo['points'] === false) {
                $msg[] =
                    'The member does not have the required promotion points for the rank selected.';
            }
        }

        if ($earlyPromotion === true) {
            $canPromote = $canPromote && $promotionInfo['early'];

            if ($promotionInfo['early'] === false) {
                $msg[] = 'The member does not qualify for early promotion';
            }
        }

        if ($tigCheck === true) {
            $canPromote = $canPromote && $promotionInfo['tig'];

            if ($promotionInfo['next'][0] !== $request->input('payGrade')) {
                // Check TiG was selected, but the paygrade was not the next one for the member
                $canPromote = false;
                $msg[] =
                    'The rank selected is not the next rank for the members current rank.  To skip this check, do not select "Check Time In Grade".';
            }

            if ($promotionInfo['tig'] === false) {
                $msg[] =
                    'The member does not have the required time in grade for the rank selected';
            }
        }

        $rankQualificationResponse = [
            'valid' => $canPromote,
            'msg' => $msg,
            'grade2check' => $payGrade2Check,
            'pinfo' => $promotionInfo,
        ];

        return Response::json($rankQualificationResponse);
    }

    public function getRibbonImage($ribbonCode, $ribbonCount, $ribbonName)
    {
        $prefix = 'ribbons/';
        $suffix = ' class="ribbon">';

        if (in_array($ribbonCode, ['MT', 'MID', 'WS'])) {
            $prefix = 'awards/stripes/';
            $suffix = '>';
        }
        $ribbonImage = $prefix.$ribbonCode.'-1.svg';
        if (file_exists(public_path($prefix.$ribbonCode.'-'.$ribbonCount.'.svg'))) {
            $ribbonImage = $prefix.$ribbonCode.'-'.$ribbonCount.'.svg';
        }

        return '<img src="'.asset($ribbonImage).'" alt="'.$ribbonName.'"'.$suffix;
    }

    public function getNewRank(User $user, string $old, string $new)
    {
        $oldBranch = Branch::where('branch', strtoupper($old))->first();
        $newBranch = Branch::where('branch', strtoupper($new))->first();

        $newPayGrade = Grade::getNewPayGrade($user, $oldBranch, $newBranch, false);

        return Response::json(
            ['new_rank' => Grade::getRankTitle($newPayGrade, null, strtoupper($new)).' ('.$newPayGrade.')']
        );
    }

    public function getUnfilteredPayGrades($branch)
    {
        return Response::json(Grade::getGradesForBranchUnFiltered($branch));
    }
}
