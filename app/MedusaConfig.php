<?php

use Jenssegers\Mongodb\Model as Eloquent;

use Illuminate\Database\Eloquent\Model;

class MedusaConfig extends Model
{
    protected $fillable = [
      'key',
      'value',
    ];

    protected $table = 'config';

    public static function set($key, $value)
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
        } catch (Exception $e) {
            \Log::error($e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
    }

    public static function _get($key, $default = null)
    {
        try {
            $item = self::where('key', '=', $key)->first();
            return isset($item->value) === true ? $item->value : $default;
        } catch (Exception $e) {
            \Log::error($e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
    }

    public static function remove($key)
    {
        try {
            self::where('key', '=', $key)->delete();
            return true;
        } catch (Exception $e) {
            \Log::error($e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
    }

    public static function get($key, $default = null, $subkey = null)
    {
        if (is_null($subkey) === true) {
            return self::_get($key, $default);
        }

        try {
            $value = self::_get($key, $default);
            return isset($value[$subkey]) === true? $value[$subkey]: $default;
        } catch (Exception $e) {
            \Log::error($e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
    }
}
