<?php

namespace Clinicare\Routes;

use Clinicare\Auth;
use Exception;
use ReflectionClass;

class Router
{

    private static $_instance;
    private $_routes = [];

    private function route($method, $url, $controller, $authenticated)
    {

        $route = str_replace('/', '\/', $url);
        $route = preg_replace_callback('/(\:\w+)/mi', function ($matchs) {
            $value = str_replace(':', '', $matchs[0]);
            return "(?P<$value>\d+)";
        }, $route);
        $args = explode('@', $controller);
        assert(sizeof($args) > 1, "Você deve informar um Controlador e Um metodo válido");
        array_push($this->_routes, [
            "route" => $route,
            "controller" => "Clinicare\\Controllers\\$args[0]",
            "call" => $args[1],
            "method" => $method,
            "authenticated" => $authenticated
        ]);
    }


    public function get($url, $controller, $authenticated = false)
    {
        return $this->route('GET', $url, $controller, $authenticated);
    }
    public function post($url, $controller, $authenticated = false)
    {
        return $this->route('POST', $url, $controller, $authenticated);
    }

    public function put($url, $controller, $authenticated = false)
    {
        return $this->route('PUT', $url, $controller, $authenticated);
    }

    public function delete($url, $controller, $authenticated = false)
    {
        return $this->route('DELETE', $url, $controller, $authenticated);
    }

    public function listen()
    {
        header('Content-Type: application/json');

        $request_uri = trim($_SERVER["REQUEST_URI"]);
        $request_method = trim($_SERVER["REQUEST_METHOD"]);
        foreach ($this->_routes as $options) {
            $route = $options["route"];
            if ($options['method'] !== $request_method) continue;
            if (preg_match("/^" . $route . "$/i", explode("?", $request_uri)[0], $args)) {
                if ($options['authenticated']) {
                    Auth::middleware();
                }
                try {
                    $class = new ReflectionClass($options['controller']);
                    $instance = $class->newInstance();
                    $instance->setArgs($args);
                    echo $instance->{$options['call']}();
                    die;
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode([
                        "error" => $e->getMessage()
                    ]);
                    die;
                }
            }
        };
        http_response_code(404);
        echo json_encode([
            "error" => "Route not found"
        ]);
    }


    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
}
