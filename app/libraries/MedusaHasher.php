<?php

class MedusaHasher implements Illuminate\Hashing\HasherInterface {

    public function make($value, array $options = array()) {
        return sha1($value);
    }

    public function check($value, $hashedValue, array $options = array()) {
        return $hashedValue == sha1($value);
    }

    public function needsRehash($hashedValue, array $options = array()) {
        return false;
    }

}