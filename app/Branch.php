<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class Branch extends Eloquent
{

    protected $fillable = [ 'branch', 'branch_name' ];

    public static function getBranchList()
    {
        foreach (self::all(['branch', 'branch_name']) as $branch) {
            $branches[$branch['branch']] = $branch['branch_name'];
        }

        asort($branches);

        $branches = ['' => 'Select a Branch'] + $branches;

        return $branches;
    }

    public static function getNavalBranchList()
    {
        foreach (self::whereIn('branch', MedusaConfig::get('chapter.naval', ["RMN", "GSN", "IAN", "RHN",]))
                ->get(['branch', 'branch_name']) as $branch) {
            $branches[$branch['branch']] = $branch['branch_name'];
        }

        asort($branches);

        $branches = ['' => 'Select a Branch'] + $branches;

        return $branches;
    }

    public static function getBranchName($branch)
    {
        $res = self::where('branch', $branch)->first();

        return $res['branch_name'];
    }
}
