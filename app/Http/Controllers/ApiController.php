<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Chapter;
use App\ExamList;
use App\Grade;
use App\Korders;
use App\Rating;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Webpatser\Countries\Countries;

class ApiController extends Controller
{

    public function getBranchList()
    {
        return Response::json(Branch::getBranchList());
    }

    public function getCountries()
    {
        $results = Countries::getList();
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

    public function getChapters()
    {
        return Response::json(Chapter::getChapters());
    }

    public function getChaptersByBranch($branchID, $location)
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
        return Response::json(Chapter::getChaptersByType('university') + Chapter::getChaptersByType('university_system'));
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
        if (Input::file('file')->isValid() === true) {
            $res =
              User::where('member_id', '=', Input::get('member_id'))->get();

            if (count($res) === 1 && $res[0]->member_id == Input::get('member_id')) {
                $user = $res[0];
                $ext = Input::file('file')->getClientOriginalExtension();
                $fileName = $user->member_id . '.' . $ext;

                Input::file('file')->move(public_path() . '/images', $fileName);

                // File uploaded, add filename to user record
                $user->filePhoto = '/images/' . $fileName;

                $this->writeAuditTrail(
                    (string)Auth::user()->_id,
                    'update',
                    'users',
                    (string)$user->_id,
                    $user->toJson(),
                    'ApiController@savePhoto'
                );

                $user->save();
            }
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
            $query = Input::get('query', null);
        }

        if (is_null($query) === true) {
            return Response::json(['suggestions' => []]);
        }

        $terms = explode(' ', $query);

        switch (count($terms)) {
            case 1:
                $query =
                  User::where('registration_status', '=', 'Active')
                      ->where(function ($query) use ($terms) {
                          $query->where(
                              'member_id',
                              'like',
                              '%' . $terms[0] . '%'
                          )
                                ->orWhere('first_name', 'like', $terms[0] . '%')
                                ->orWhere('last_name', 'like', $terms[0] . '%');
                      });
                break;
            case 2:
                $query =
                  User::where('first_name', 'like', $terms[0] . '%')
                      ->where('last_name', 'like', $terms[1] . '%')
                      ->where('registration_status', '=', 'Active');
                break;
            default:
                $query =
                  User::where('first_name', 'like', $terms[0] . '%')
                      ->where('middle_name', 'like', $terms[1] . '%')
                      ->where('last_name', 'like', $terms[2] . '%')
                      ->where('registration_status', '=', 'Active');
        }

        $results = $query->get();

        $suggestions = [];

        foreach ($results as $member) {
            $suggestions[] =
              [
                'value' => $member->member_id . ' ' . $member->first_name . ' ' . (!empty($member->middle_name) ? $member->middle_name . ' ' : '') . $member->last_name . (!empty($member->suffix) ? ' ' . $member->suffix : '') . ' (' . $member->getAssignmentName(
                    'primary'
                ) . ')',
                'data'  => $member->id
              ];
        }

        return Response::json(['suggestions' => $suggestions]);
    }

    public function findChapter($query = null)
    {
        if (empty($query) === true) {
            $query = Input::get('query', null);
        }

        if (is_null($query) === true) {
            return Response::json(['suggestions' => []]);
        }

        $results =
          Chapter::orderBy('chapter_name', 'asc')
                 ->where('chapter_name', 'like', '%' . $query . '%')
                 ->whereNull('decommission_date')
                 ->get();

        $suggestions = [];

        foreach ($results as $chapter) {
            $suggestions[] =
              [
                'value' => $chapter->chapter_name,
                'data'  => $chapter->id,
              ];
        }

        return Response::json(['suggestions' => $suggestions]);
    }

    public function findExam()
    {
        $query = Input::get('query', null);

        if (is_null($query) === true) {
            return Response::json(['suggestions' => []]);
        }

        $results =
          ExamList::where('name', 'like', '%' . $query . '%')
                  ->orWhere('exam_id', 'like', '%' . $query . '%')
                  ->get();

        $suggestions = [];

        foreach ($results as $exam) {
            if ($exam->enabled === true) {
                $suggestions[] =
                  [
                    'value' => $exam->name . ' (' . $exam->exam_id . ')',
                    'data'  => $exam->exam_id
                  ];
            }
        }

        return Response::json(['suggestions' => $suggestions]);
    }

    public function getScheduledEvents($user, $continent = null, $city = null)
    {
        return Response::json([
          'events' => $user->getScheduledEvents($continent, $city)
        ]);
    }

    public function checkInMember(
        $event,
        $user,
        $member,
        $continent = null,
        $city = null
    ) {
        if (is_object($user) === false) {
            return Response::json(['error' => 'Invalid User']);
        }
        return Response::json($user->checkMemberIn(
            $event,
            $member,
            $continent,
            $city
        ));
    }

    public function getRibbonRack($member_id)
    {
        $user = User::where('member_id', '=', $member_id)->first();

        if (isset($user->awards) === true) {
            $user->leftRibbonCount = count($user->getRibbons('L'));
            $user->leftRibbons = $user->getRibbons('L');

            if (Input::get('mobile', 'false') === 'true') {
                return view('partials.leftribbons', ['user' => $user]);
            } else {
                return view('ribbonrack', ['user' => $user]);
            }
        }
    }
}
