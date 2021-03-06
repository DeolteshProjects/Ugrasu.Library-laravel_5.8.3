<?php

return [
    'oracle_local' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = )))'),
        'host'           => env('DB_HOST', ),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', ''),
        'username'       => env('DB_USERNAME', ''),
        'password'       => env('DB_PASSWORD', ''),
        'charset'        => env('DB_CHARSET', ''),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', ''),
        'server_version' => env('DB_SERVER_VERSION', ''),
    ],
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = )))'),
        'host'           => env('DB_HOST', 'localhost'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', 'XE'),
        'username'       => env('DB_USERNAME', 'SYSTEM'),
        'password'       => env('DB_PASSWORD', 'root'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];
