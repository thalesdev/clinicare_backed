<?php

namespace Clinicare\Database;

use Illuminate\Database\Capsule\Manager as Capsule;



class Database
{
    public static function boot()
    {
        /**
         * @return Illuminate\Database\Capsule\Manager $capsule
         */
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => $_ENV['DATABASE_DRIVER'],
            'host'      => $_ENV['DATABASE_HOST'],
            'database'  => $_ENV['DATABASE_NAME'],
            'username'  => $_ENV['DATABASE_USERNAME'],
            'password'  => $_ENV['DATABASE_PASSWORD'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();


        $capsule->connection()->enableQueryLog();
        return $capsule;
    }
}
