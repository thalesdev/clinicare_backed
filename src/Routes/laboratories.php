<?php

use Clinicare\Routes\Router;

$router = Router::getInstance();


$router->get('/laboratories', 'LaboratoriesController@index', true);
$router->get('/laboratories/:id', 'LaboratoriesController@show', true);
$router->post('/laboratories', 'LaboratoriesController@store', true);
$router->delete('/laboratories/:id', 'LaboratoriesController@destroy', true);
