<?php

namespace App;

use Illuminate\Contracts\Hashing\Hasher;

class MedusaHasher implements Hasher
{
    public function make($value, array $options = [])
    {
        return sha1($value);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        return $hashedValue == sha1($value);
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
