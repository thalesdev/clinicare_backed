<?php

namespace Clinicare\Controllers;

class Controller
{
    protected $input;
    protected $args = [];
    public function __construct()
    {
        $json = file_get_contents('php://input');
        $this->_input = (array)json_decode($json);
    }


    public function setArgs($args)
    {
        $this->args = $args;
    }

    public function getArgs()
    {
        return $this->args;
    }

    protected function input($name)
    {
        if (key_exists($name, $this->_input)) {
            return $this->_input[$name];
        }
    }

    protected function inputsWithKeys($keys)
    {
        $rawData = [];
        foreach ($keys as $key) {
            $rawData[$key] = $this->input($key);
        }
        return $rawData;
    }


    protected function arg($name)
    {
        if (key_exists($name, $this->args)) {
            return $this->args[$name];
        }
    }

    protected function res_status($code)
    {
        if ($code) {
            http_response_code($code);
        } else {
            return http_response_code();
        }
    }

    protected function abort($code = 0, $message = null)
    {
        $this->res_status($code);
        if ($message) {
            echo json_encode([
                "message" => $message
            ]);
        }
        die;
    }
}
