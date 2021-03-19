<?php

use Clinicare\Routes\Router;

$router = Router::getInstance();


$router->get('/exams', 'ExamsController@index', true);
$router->get('/exams/:id', 'ExamsController@show', true);
$router->post('/exams', 'ExamsController@store', true);
$router->delete('/exams/:id', 'ExamsController@destroy', true);
