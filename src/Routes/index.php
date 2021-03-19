<?php

use Clinicare\Routes\Router;

$router = Router::getInstance();

$router->get('/', 'IndexController@index');


// autenticação
$router->post('/session', 'SessionController@store');


require_once __DIR__ . "/appointments.php";
require_once __DIR__ . "/exams.php";
require_once __DIR__ . "/doctors.php";
require_once __DIR__ . "/laboratories.php";
require_once __DIR__ . "/patients.php";
