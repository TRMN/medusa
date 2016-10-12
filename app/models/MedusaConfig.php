<?php

use Jenssegers\Mongodb\Model as Eloquent;

class MedusaConfig extends Eloquent
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

    public static function get($key)
    {
        try {
            $item = self::where('key', '=', $key)->firstOrFail();
            return $item->value;
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
}