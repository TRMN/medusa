<?php

return [

    'connections' => [

        'mysql' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'medusa',
            'username' => 'homestead',
            'password' => 'secret',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ],

        'mongodb' => [
            'driver' => 'mongodb',
            'host' => 'localhost',
            'port' => 27017,
            'database' => 'medusa',
            'username' => 'medusadev',
            'password' => 'medusadev',
        ]
    ],
];
