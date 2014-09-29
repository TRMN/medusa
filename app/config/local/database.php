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
            'host' => 'ds039850.mongolab.com:39850',
            'database' => 'medusa',
            'username' => 'medusadev',
            'password' => 'medusadev',
        ]
    ],
];
