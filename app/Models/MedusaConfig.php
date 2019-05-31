<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MedusaConfig extends Eloquent
{
    protected $fillable = [
      'key',
      'value',
    ];

    protected $table = 'config';

    /**
     * Add or update a config value in the database.
     *
     * @param string $key   Config key to set
     * @param mixed  $value What to set the config key to
     *
     * @return bool
     */
    public static function set(string $key, $value)
    {
        try {
            // If key already exists, update it
            $item = self::where('key', '=', $key)->first();
            if (empty($item->value) === true) {
                $item = self::create(['key' => $key, 'value' => $value]);
            } else {
                $item->value = $value;
                $item->save();
            }

            return $item->id;
        } catch (\Exception $e) {
            Log::error($e->getMessage()."\n".$e->getTraceAsString());

            return false;
        }
    }

    /**
     * Remove a config key.
     *
     * @param string $key Config key to remove
     *
     * @return bool
     */
    public static function remove(string $key)
    {
        try {
            self::where('key', '=', $key)->delete();

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage()."\n".$e->getTraceAsString());

            return false;
        }
    }

    /**
     * Get a config value.
     *
     * @param string            $key     Config key to retrieve
     * @param string|array|null $default Default value to return
     * @param string|null       $subkey  If the config value is an array, return
     *                                   this key
     *
     * @return bool|null|mixed
     */
    public static function get(string $key, $default = null, string $subkey = null)
    {
        if (is_null($subkey) === true) {
            try {
                $item = self::where('key', '=', $key)->first();

                return isset($item->value) === true ? $item->value : $default;
            } catch (\Exception $e) {
                Log::error($e->getMessage()."\n".$e->getTraceAsString());

                return false;
            }
        } else {
            try {
                $item = self::where('key', '=', $key)->first();

                return isset($item->value[$subkey]) === true ?
                    $item->value[$subkey] :
                    $default;
            } catch (\Exception $e) {
                Log::error($e->getMessage()."\n".$e->getTraceAsString());

                return false;
            }
        }
    }
}
