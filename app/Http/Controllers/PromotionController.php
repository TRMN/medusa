<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Grade;
use App\Permissions\MedusaPermissions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    use MedusaPermissions;

    public function index(Chapter $chapter)
    {
        if (($redirect = $this->canPromote($chapter->id)) !== true) {
            return redirect(URL::previous())->with('message', 'You do not have permission to view that page');
        }

        // Chapter members who are promotable early by CO
        $early = [];

        // Chapter members who are promotable by CO
        $promotable = [];

        // Merit promotions to O-1
        $merit = [];

        // Chapter members who should be sent to a promotion board
        $board = [];

        // Chapter members a warrant can be requested for
        $warrant = [];

        // Chapter members
        $members = $chapter->getAllCrewIncludingChildren();

        // Iterate over the whole crew
        foreach ($members as $member) {
            if ($member->id == Auth::user()->id) {
                // Can't promote yourself, skip
                continue;
            }

            if (is_null($member->isPromotable()) === false ||
                is_null($member->isPromotableEarly()) == false) {
                $pi = $member->getPromotableInfo();

                $flags = [
                    'promotable' => $pi['tig'] && $pi['exams'] && $pi['points'],
                    'early' => $pi['exams'] && $pi['points'] && $pi['early'],
                ];

                if ($flags['promotable'] === true || $flags['early'] === true) {
                    // Crew member is promotable, determine which bucket

                    foreach ($pi['next'] as $rank) {
                        $memberCopy = new \stdClass();
                        $memberCopy->id = $member->id;
                        $memberCopy->fullName = $member->getFullName(true);
                        $memberCopy->next_grade = $rank;
                        $memberCopy->primaryChapter =
                            $member->getAssignmentName('primary');

                        // Parse the pay grade
                        $paygrade = explode('-', $rank);

                        // Process based on Enlisted/Civilian/Warrant/Officer/Flag
                        switch ($paygrade[0]) {
                            case 'E':
                            case 'C':
                                if ($paygrade[1] < 7) {
                                    // Promotable by the CO to this grade
                                    if ($flags['early'] === true) {
                                        $early[] = $memberCopy;
                                    } else {
                                        $promotable[] = $memberCopy;
                                    }
                                } else {
                                    $board[] = $memberCopy;
                                }
                                break;
                            case 'WO':
                                if ($paygrade[1] == 1) {
                                    $warrant[] = $memberCopy;
                                } else {
                                    $board[] = $memberCopy;
                                }

                                break;
                            case 'O':
                                if ($paygrade[1] == 1) {
                                    $merit[] = $memberCopy;
                                } elseif ($paygrade[1] == 2 &&
                                    Auth::user()->hasPermissions(['PROMOTE_E6O2']) === true &&
                                    Auth::user()->isFleetCO() === true) {
                                    $promotable[] = $memberCopy;
                                } else {
                                    $board[] = $memberCopy;
                                }
                                break;
                        }
                        unset($memberCopy);
                    }
                }
            }
        }

        return view('promotions.index', [
            'chapter' => $chapter,
            'early' => $early,
            'promotable' => $promotable,
            'board' => $board,
            'warrant' => $warrant,
            'merit' => $merit,
        ]);
    }

    public function promote(Request $request)
    {
        $chapterId = $request->chapter;

        if (($redirect = $this->canPromote($chapterId)) !== true) {
            return redirect(URL::previous())->with(
                'message',
                'You do not have permission to view that page'
            );
        }

        $payload = json_decode($request->payload, true);

        foreach (['early', 'promotable'] as $key) {
            if (empty($payload[$key]) === true) {
                $payload[$key] = [];
            }
        }

        $promoted = array_merge(
            $this->_processPromotionRequests($payload['early'], true),
            $this->_processPromotionRequests($payload['promotable'])
        );

        return view('promotions.results', ['chapter' => Chapter::find($chapterId), 'promotions' => $promoted]);
    }

    private function _processPromotionRequests(array $promotions, bool $early = false)
    {
        $promoted = [];

        foreach ($promotions as $member) {
            $user = User::find($member['memberId']);

            $from = Grade::getRankTitle(
                    $user->rank['grade'],
                    $user->getRate(),
                    $user->branch
                ).' ('.$user->rank['grade'].')';

            $user->promoteMember($member['grade'], $early);

            $to = Grade::getRankTitle(
                    $member['grade'],
                    $user->getRate(),
                    $user->branch
                ).' ('.$member['grade'].')';

            $promoted[] = [
                'name' => $user->getFullName(),
                'from' => $from,
                'to' => $to,
                'member_id' => $user->member_id,
            ];
        }

        return $promoted;
    }
}
