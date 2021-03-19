<?php

namespace Clinicare\Controllers;

use Clinicare\Models\User;
use DateTime;
use \Firebase\JWT\JWT;

class SessionController extends Controller

{

    public function store()
    {
        $user = User::where('email', $this->input('email'))->where('password', md5($this->input('password')))->with(['laboratory', 'laboratory.exam_types'])->first();
        if ($user) {
            $key = $_ENV['JWT_SECRET'];
            $payload = array(
                'exp' => (new DateTime("now"))->getTimestamp() + (60 * 60 * 24 * 5),
                'id' => $user->id,
                'emai' => $user->email
            );
            $jwt = JWT::encode($payload, $key);
            return json_encode([
                "token" => $jwt,
                "user" => $user
            ]);
        }
        $this->res_status(403);
        echo json_encode(['error' => 'Senha ou Usuario invalidos']);
    }
}
