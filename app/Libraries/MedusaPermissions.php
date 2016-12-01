<?php

/*
 * Medusa Permission helpers
 */

namespace Medusa\Permissions;

trait MedusaPermissions
{

    public function checkPermissions($permissions)
    {
        if ($this->hasPermissions($permissions) === false) {
            return \Redirect::to(\URL::previous())->with('message', 'You do not have permission to view that page');
        }

        return true;
    }

    public function loginValid()
    {
        if (\Auth::check() === false) {
            return \Redirect::to(\URL::previous())->with('message', 'You do not have permission to view that page');
        }

        return true;
    }

    public function hasPermissions($permissions, $skipAll = false)
    {
        if (empty(\Auth::user()) === true) {
            return false; // Not logged in, don't waste time
        }

        if (in_array('ALL_PERMS', \Auth::user()->permissions) === true && $skipAll === false) {
            return true; // Don't waste time :)
        }

        if (is_array($permissions) === false) {
            $permissions = [$permissions];
        }

        foreach ($permissions as $permission) {
            if (in_array($permission, \Auth::user()->permissions) === true) {
                return true; // Found at least one of the provided permissions the user's permission's array
            }
        }

        return false; // Permission not found
    }

    public function hasAllPermissions()
    {
        if (empty(\Auth::user()) === true) {
            return false; // Not logged in, don't waste time
        }

        if (in_array('ALL_PERMS', \Auth::user()->permissions) === true) {
            return true; // Don't waste time :)
        }

        return false;
    }

    /**
     * Determine if the logged in user is in the chain of command provided user
     *
     * @param User $user
     *
     * @returns bool
     */
    public function isInChainOfCommand($param)
    {

        if ($param instanceof \User) {
            //called with a user object, get the id's of all ships/echelons above the users ship/echelon as well as child ship/echelon
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
                        array_merge($echelonIdsToCheck, \Chapter::find($chapterId)->getChapterIdWithParents());
                }
            }
        } elseif (is_array($param)) {
            $echelonIdsToCheck = $param;
        } else {
            return false;
        }

        // Check if the logged in user has the correct permissions and is in the specified users Chain of Command or in
        // the array of chapter ids passed in

        if ($this->hasPermissions(['DUTY_ROSTER']) === true) {
            $rosters = ( \Auth::user()->duty_roster );
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
}
