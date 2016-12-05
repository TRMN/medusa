<?php

use Jenssegers\Mongodb\Model as Eloquent;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
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
    ];

    public static function _getAwards($location)
    {
        $awards = [];

        foreach (self::where('location', '=', $location)
                      ->orderBy('display_order')
                      ->get() as $ribbon) {
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
                    foreach (explode(',', $ribbon->replaces) as $item) {
                        $tmp[] = $awards[$item];
                        unset($awards[$item]);
                    }
                    $ribbons[] = ['group' => [
                      'label' => $ribbon->group_label,
                      'awards' => $tmp]
                    ];
                }
            }
        }

        return $ribbons;
    }

    public static function getLeftRibbons()
    {
        return self::_getAwards('L');
    }

    public static function getTopBadges()
    {
        return self::_getAwards('TL');
    }

    public static function getLeftSleeve()
    {
        return self::_getAwards('LS');
    }

    public static function getRightSleeve()
    {
        return self::_getAwards('RS');
    }

    public static function getDisplayOrder($code)
    {
        return self::where('code', '=', $code)->first()->display_order;
    }

    public static function getAwardByCode($code)
    {
        return self::where('code', '=', $code)->orderBy('display_order')->first();
    }
}
