<?php

use Clinicare\Routes\Router;

$router = Router::getInstance();

$router->get('/', 'IndexController@index');


// autenticação
$router->post('/session', 'SessionController@store');


require_once __DIR__ . "/appointments.php";
