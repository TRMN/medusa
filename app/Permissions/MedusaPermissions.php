<?php

namespace App\Models\Permissions;

use App\Models\User;
use App\Models\Chapter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

trait MedusaPermissions
{
    public function checkPermissions($permissions, $skipAll = false)
    {
        if ($this->hasPermissions($permissions, $skipAll) === false) {
            return redirect(URL::previous())->with(
                'message',
                'You do not have permission to view that page'
            );
        }

        return true;
    }

    public function canDeleteExam($score)
    {
        if (($this->hasPermissions(['EDIT_GRADE']) && rtrim($score, '%') !== '0') ||
            $this->hasPermissions(['UPLOAD_EXAMS'])) {
            return true;
        } else {
            return redirect(URL::previous())->with(
                'message',
                'You do not have permission to view that page'
            );
        }
    }

    public function hasDutyRosterForAssignedShip()
    {
        return Auth::user()->hasAllPermissions() === true ? true :
                Auth::user()->hasPermissions(['DUTY_ROSTER']) &&
                in_array(
                    Auth::user()->getAssignedShip(),
                    explode(',', Auth::user()->duty_roster)
                );
    }

    public function loginValid()
    {
        if (Auth::check() === false) {
            return redirect(URL::previous())->with(
                'message',
                'You do not have permission to view that page'
            );
        }

        return true;
    }

    public function hasPermission($permissions, $skipAll = false)
    {
        return $this->hasPermissions($permissions, $skipAll);
    }

    public function hasPermissions($permissions, $skipAll = false)
    {
        if (empty(Auth::user()) === true) {
            return false; // Not logged in, don't waste time
        }

        if (in_array('ALL_PERMS', Auth::user()->permissions) === true &&
            $skipAll === false) {
            return true; // Don't waste time :)
        }

        if (is_array($permissions) === false) {
            $permissions = [$permissions];
        }

        foreach ($permissions as $permission) {
            if (in_array($permission, Auth::user()->permissions) === true) {
                return true; // Found at least one of the provided permissions the user's permission's array
            }
        }

        return false; // Permission not found
    }

    public function hasAllPermissions()
    {
        if (empty(Auth::user()) === true) {
            return false; // Not logged in, don't waste time
        }

        if (in_array('ALL_PERMS', Auth::user()->permissions) === true) {
            return true; // Don't waste time :)
        }

        return false;
    }

    /**
     * Determine if the logged in user is in the chain of command provided user.
     *
     * @param User $user
     *
     * @returns bool
     */
    public function isInChainOfCommand($param)
    {
        if ($param instanceof User) {
            //called with a user object, get the id's of all ships/echelons above the users ship/echelon
            $chapterIds = [];
            foreach (['primary', 'secondary', 'additional', 'extra'] as $position) {
                $chapterIds[] = $param->getAssignmentId($position);
            }

            if (count($chapterIds) < 1) {
                return false;
            }

            $echelonIdsToCheck = [];
            foreach ($chapterIds as $chapterId) {
                if ($chapterId !== false) {
                    $echelonIdsToCheck =
                        array_merge(
                            $echelonIdsToCheck,
                            Chapter::find($chapterId)->getChapterIdWithParents()
                        );
                }
            }
        } elseif (is_array($param)) {
            $echelonIdsToCheck = $param;
        } else {
            return false;
        }

        // Check if the logged in user has the correct permissions and is in the specified users Chain of Command or in
        // the array of chapter ids passed in

        if (Auth::user()->hasPermissions(['DUTY_ROSTER']) === true) {
            $rosters = (Auth::user()->duty_roster);
            if (is_array($rosters) === false) {
                $rosters = explode(',', trim($rosters, ','));
            }
            foreach ($rosters as $roster) {
                if (in_array($roster, $echelonIdsToCheck) === true) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if the user has one of the specified permissions
     * (config:permissions.restricted) AND the specified permission
     * ($permName) is in config:permissions.restricted.
     *
     * @param string $permName
     *
     * @return bool
     */
    public function checkRestrictedAccess(string $permName)
    {
        $restrictedPerms = config('permissions.restricted');

        if (in_array($permName, $restrictedPerms) === false) {
            return false; // Short circut the checks if the perm being checked for is not in the restricted list
        }

        if (in_array($permName, $restrictedPerms) === true &&
            in_array($permName, Auth::user()->permissions)) {
            return true;
        }

        return false;
    }

    public function promotionPointsEditAccess(User $user)
    {
        if ((Auth::user()->hasPermissions(['EDIT_SELF']) === true &&
             Auth::user()->id == $user->id)
            || Auth::user()->hasPermissions(['EDIT_MEMBER'])
            || Auth::user()->isInChainOfCommand($user) === true) {
            return true;
        }

        return false;
    }

    public function canPromote($chapterId)
    {
        if ((Auth::user()->hasPermissions(['PROMOTE_E6O1']) === true &&
             (Auth::user()->isCoAssignedShip() === true) || Auth::user()->isCommandingOfficer($chapterId))
            || Auth::user()->hasAllPermissions()
            || (Auth::user()->isFleetCO() === true &&
                Auth::user()->hasPermissions(['PROMOTE_E6O2']) === true)) {
            return true;
        }

        return false;
    }
}
