<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Korders extends Eloquent
{
    protected $fillable = ['order', 'filename', 'classes'];

    public function getPrecedence($options)
    {
        if (is_array($options) === false) {
            $options = [
              'type'  => 'postnominal',
              'value' => $options,
            ];
        }

        foreach ($this->classes as $item) {
            if ($item[$options['type']] == $options['value']) {
                return $item['precedence'];
            }
        }

        return false;
    }

    public function getClassName($postNominal)
    {
        foreach ($this->classes as $item) {
            if ($item['postnominal'] == $postNominal) {
                return $item['class'];
            }
        }

        return false;
    }
}
