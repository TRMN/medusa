<?php


class Branch extends Moloquent {

    static function getBranchList()
    {
        foreach (Branch::all(array('branch', 'branch_name')) as $branch) {
            $branches[$branch['branch']] = $branch['branch_name'];
        }

        asort($branches);

        $branches = ['' => 'Select a Branch'] + $branches;

        return $branches;
    }

} 
