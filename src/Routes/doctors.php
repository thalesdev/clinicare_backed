<?php

use Clinicare\Routes\Router;

$router = Router::getInstance();


$router->get('/doctors', 'DoctorsController@index', true);
$router->get('/doctors/:id', 'DoctorsController@show', true);
$router->post('/doctors', 'DoctorsController@store', true);
$router->delete('/doctors/:id', 'DoctorsController@destroy', true);
