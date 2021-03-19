<?php

/**
 * Clinicare backend v2
 */

error_reporting(E_ALL);

require_once "Routes/index.php";

require_once __DIR__ . "/cors.php";


use Clinicare\Database\Database;
use Clinicare\Models\User;
use Clinicare\Routes\Router;

// habilita o cors
cors();

// instancia nossa base de dados
Database::boot();



$router = Router::getInstance();
$router->listen();
