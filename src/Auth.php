<?php

namespace Clinicare;

use Clinicare\Models\User;
use Exception;
use \Firebase\JWT\JWT;

class Auth
{
    private static $_instance;
    private $user;

    public static function attemp($user)
    {
        $instance = self::getInstance();
        $instance->setUser($user);
    }

    public static function user()
    {
        $instance = self::getInstance();
        return $instance->getUser();
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
    public function getUser()
    {
        return $this->user;
    }


    public static function middleware(): void
    {
        $token  = explode('Bearer', $_SERVER['HTTP_AUTHORIZATION']);
        assert(sizeof($token) > 1, "você deve enviar uma autenticação no formato Bearer Token");
        $jwt = str_replace(' ', '', $token[1]);
        try {
            $decoded = JWT::decode($jwt, $_ENV['JWT_SECRET'], array('HS256'));
            $user = User::find($decoded->id);
            self::attemp($user);
        } catch (Exception $e) {
            http_response_code(403);
            echo json_encode([
                "error" => "Bad Credentials"
            ]);
            die;
        }
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
}
