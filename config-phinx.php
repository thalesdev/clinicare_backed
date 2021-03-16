<?php

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


return [
    'paths' => [
        'migrations' => 'src/migrations'
    ],
    'migration_base_class' => '\Clinicare\Database\Migration\Migration',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'dev',
        'dev' => [
            'adapter' => $_ENV['DATABASE_DRIVER'],
            'host' => $_ENV['DATABASE_HOST'],
            'name' => $_ENV['DATABASE_NAME'],
            'user' => $_ENV['DATABASE_USERNAME'],
            'pass' => $_ENV['DATABASE_PASSWORD'],
            'port' => $_ENV['DATABASE_PORT']
        ]
    ]
];
