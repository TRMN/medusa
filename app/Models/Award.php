<?php

namespace App\Models;

//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * Class Award.
 *
 * @property int display_order
 * @property string name
 * @property string code
 * @property string post_nominal
 * @property string replaces
 * @property string location
 * @property bool multiple
 * @property string group_label
 * @property string image
 * @property string branch
 */
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
        'star_nation',
    ];

    /**
     * Get the awards for the specified uniform location.
     *
     * @param $location
     * @param array $limit
     *
     * @return array
     */
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
                            'label'    => $ribbon->group_label,
                            'awards'   => $tmp,
                            'multiple' => $multiple,
                        ],
                    ];
                }
            }
        }

        return $ribbons;
    }

    /**
     * Get any a list of all Aerospace Wings.
     *
     * @todo Refactor to use the config table
     *
     * @param array $limit
     *
     * @return array
     */
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
            'OMSW',
        ]
    ) {
        return self::_getAwards('TL', $limit);
    }

    /**
     * Get the ribbons that go on the left side of the uniform.
     *
     * @return array
     */
    public static function getLeftRibbons()
    {
        return self::_getAwards('L');
    }

    /**
     * Get the ribbons that go on the right side of the uniform.
     *
     * @return array
     */
    public static function getRightRibbons()
    {
        return self::_getAwards('R');
    }

    /**
     * Get the qualification badges that go above the ribbons.
     *
     * @param array $limit
     *
     * @return array
     */
    public static function getTopBadges(array $limit = [])
    {
        return self::_getAwards('TL', $limit);
    }

    /**
     * Get left sleeve items, such as HMS Unconquered.
     *
     * @return array
     */
    public static function getLeftSleeve()
    {
        return self::_getAwards('LS');
    }

    /**
     * Get the right sleeve stripes.
     *
     * @return array
     */
    public static function getRightSleeve()
    {
        return self::_getAwards('RS');
    }

    /**
     * Get the Army Weapons Qualification Badges.
     *
     * @return array
     */
    public static function getArmyWeaponQualificationBadges()
    {
        return self::_getAwards('AWQ');
    }

    /**
     * Get an awards display order.
     *
     * @param $code
     *
     * @return int|mixed
     */
    public static function getDisplayOrder($code)
    {
        return self::where('code', '=', $code)->first()->display_order;
    }

    /**
     * Get an award by the award code.
     *
     * @param $code
     *
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public static function getAwardByCode($code)
    {
        return self::where('code', '=', $code)
                   ->first();
    }

    /**
     * Get the points for an award.
     *
     * @param string $code
     *
     * @return mixed
     */
    public static function getPointsForAward(string $code)
    {
        return self::where('code', $code)->first()->points;
    }

    /**
     * Get the name of the award.
     *
     * @param string $code
     *
     * @return mixed|string
     */
    public static function getAwardName(string $code)
    {
        return self::where('code', $code)->first()->name;
    }

    /**
     * Get the name of the image to use.
     *
     * @param string $code
     *
     * @return mixed|string
     */
    public static function getAwardImage(string $code)
    {
        return self::where('code', $code)->first()->image;
    }

    /**
     * Update the award display order.
     *
     * @param $code
     * @param $display_order
     *
     * @return bool
     */
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
