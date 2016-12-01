<?php

return [

    'driver' => 'redis',
    'path' => storage_path() . '/cache',
    'connection' => 'default',
    'table' => 'cache',
    'prefix' => 'laravel',

];
