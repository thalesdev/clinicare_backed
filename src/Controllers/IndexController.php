<?php

namespace Clinicare\Controllers;


class IndexController extends Controller

{
    public function index()
    {
        echo json_encode(['msg' => 'ola chupa cu']);
    }
}
