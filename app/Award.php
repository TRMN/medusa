<?php

namespace App;

//use Moloquent\Eloquent\Model as Eloquent;
use Mockery\Exception;
use Moloquent\Eloquent\Model as Eloquent;

class Award extends Eloquent
{
    protected $fillable = [
        'display_order',
        'name',
        'code',
        'post_nominal',
        'replaces',
        'location',
        'multiple',
        'group_label',
        'image',
        'branch',
        'code',
    ];

    public static function _getAwards($location, array $limit = [])
    {
        $awards = [];

        $query = self::where('location', '=', $location);

        if (count($limit) > 0) {
            $query = $query->whereIn('code', $limit);
        }

        $query = $query->orderBy('display_order')->get();

        foreach ($query as $ribbon) {
            $awards[$ribbon->code] = $ribbon;
        }

        $ribbons = [];

        foreach ($awards as $code => $ribbon) {
            if (isset($awards[$code]) === true) {
                if (empty($ribbon->replaces) === true) {
                    $ribbons[] = $ribbon;
                } else {
                    // Only one of these ribbons are allowed
                    $tmp = [$ribbon];
                    $multiple = false;

                    foreach (explode(',', $ribbon->replaces) as $item) {
                        if (empty($awards[$item]) === false) {
                            $tmp[] = $awards[$item];

                            if ($awards[$item]->multiple === true) {
                                $multiple = true;
                            }

                            unset($awards[$item]);
                        }
                    }

                    $ribbons[] = [
                        'group' => [
                            'label' => $ribbon->group_label,
                            'awards' => $tmp,
                            'multiple' => $multiple,
                        ]
                    ];
                }
            }
        }

        return $ribbons;
    }

    public static function getAerospaceWings(
        array $limit = [
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
            'OMSW'
        ]
    )
    {
        return self::_getAwards('TL', $limit);
    }

    public static function getLeftRibbons()
    {
        return self::_getAwards('L');
    }

    public static function getRightRibbons()
    {
        return self::_getAwards('R');
    }

    public static function getTopBadges(array $limit = [])
    {
        return self::_getAwards('TL', $limit);
    }

    public static function getLeftSleeve()
    {
        return self::_getAwards('LS');
    }

    public static function getRightSleeve()
    {
        return self::_getAwards('RS');
    }

    public static function getArmyWeaponQualificationBadges()
    {
        return self::_getAwards('AWQ');
    }

    public static function getDisplayOrder($code)
    {
        return self::where('code', '=', $code)->first()->display_order;
    }

    public static function getAwardByCode($code)
    {
        return self::where('code', '=', $code)
            ->first();
    }

    public static function updateDisplayOrder($code, $display_order)
    {
        $award = self::where('code', $code)->first();
        $award->display_order = $display_order;
        try {
            $award->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
