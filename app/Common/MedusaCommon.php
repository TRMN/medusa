<?php

namespace App\Common;

use Illuminate\Support\Arr;

/**
 * Trait MedusaCommon.
 *
 * Common utility methods
 */
trait MedusaCommon
{
    /**
     * Function filterArray.
     *
     * Filter an array using a regular expression.  Return only elements of the array that the key matches the regex
     *
     * @param array  $array
     * @param string $search
     *
     * @return array $list
     */
    private function filterArray(array $array, $regex)
    {
        $list = Arr::where(
            $array,
            function ($value, $key) use ($regex) {
                if (preg_match($regex, $key) === 1) {
                    return true;
                }

                return false;
            }
        );

        return $list;
    }

    /**
     * Function filterArrayInverse.
     *
     * Filter an array using a regular expression.  Return only elements of the array that the key does not match
     * the regex
     *
     * @param array $array
     * @param $regex
     *
     * @return array
     */
    public function filterArrayInverse(array $array, $regex)
    {
        $list = Arr::where(
            $array,
            function ($value, $key) use ($regex) {
                if (preg_match($regex, $key) === 1) {
                    return false;
                }

                return true;
            }
        );

        return $list;
    }
}
