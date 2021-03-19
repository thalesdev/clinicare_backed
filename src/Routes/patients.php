<?php

use Clinicare\Routes\Router;

$router = Router::getInstance();


$router->get('/patients', 'PatientsController@index', true);
// $router->get('/patients/:id', 'PatientsController@show', true);
$router->post('/patients', 'PatientsController@store', true);
// $router->delete('/patients/:id', 'PatientsController@destroy', true);
