<?php

use Clinicare\Routes\Router;

$router = Router::getInstance();


$router->get('/appointments', 'AppointmentsController@index', true);
$router->get('/appointments/:id', 'AppointmentsController@show', true);
$router->post('/appointments', 'AppointmentsController@store', true);
$router->delete('/appointments/:id', 'AppointmentsController@destroy', true);
