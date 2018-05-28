<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class Branch extends Eloquent
{

    protected $fillable = [ 'branch', 'branch_name' ];

    static function getBranchList()
    {
        foreach (self::all(['branch', 'branch_name']) as $branch) {
            $branches[$branch['branch']] = $branch['branch_name'];
        }

        asort($branches);

        $branches = ['' => 'Select a Branch'] + $branches;

        return $branches;
    }

    static function getNavalBranchList()
    {
        foreach (self::whereIn('branch', ['RMN', 'GSN', 'IAN', 'RHN'])->get(['branch', 'branch_name']) as $branch) {
            $branches[$branch['branch']] = $branch['branch_name'];
        }

        asort($branches);

        $branches = ['' => 'Select a Branch'] + $branches;

        return $branches;
    }

    static function getBranchName($branch)
    {
        $res = self::where('branch', $branch)->first();

        return $res['branch_name'];
    }
}
