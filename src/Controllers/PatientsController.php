<?php

namespace Clinicare\Controllers;

use Clinicare\Models\User;
use Clinicare\Models\Address;

use Exception;

class PatientsController extends Controller
{

    public function index()
    {
        return User::where('type', 2)->get()->toJson();
    }

    public function show()
    {
    }

    public function store()
    {

        $user_input = $this->inputsWithKeys([
            'name',
            'email',
            'phone',
            'birth',
            // 'crm',
            'gender',
            'birth',
            'marital_status',
            'nationality',
            'naturalness',
            'cpf',
            'rg'
        ]);

        $address_input = $this->inputsWithKeys([
            "phone",
            "number",
            "complement",
            "address",
            "state",
            "district",
            "city",
            "zipcode",
        ]);

        try {
            $user = User::create(array_merge(
                $user_input,
                [
                    "password" => md5($this->input("password") || 'senha123'),
                    "type" => 2
                ]
            ));
            $address = Address::create($address_input);
            $user->address()->associate($address);
            $user->save();
            $this->res_status(201);
            return $user->toJson();
        } catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
            $this->abort(403);
        }
    }
    public function destroy()
    {
    }
}
