<?php

namespace App\Libraries;


class MedusaHasher implements Illuminate\Hashing\HasherInterface
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
