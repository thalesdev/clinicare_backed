<?php

namespace Clinicare\Controllers;

use Clinicare\Models\User;
use Clinicare\Models\Address;
use Clinicare\Models\OccupationArea;
use Exception;

class DoctorsController extends Controller
{

    public function index()
    {
        return User::where('type', 3)->get()->toJson();
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
            'crm',
            'gender',
            'birth',
            'salary',
            'marital_status',
            'nationality',
            'naturalness',
            'specialty',
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
                    "type" => 3
                ]
            ));
            $address = Address::create($address_input);
            $occupation = OccupationArea::firstOrCreate([
                "name" => $this->input('occupation_area')
            ]);

            $user->address()->associate($address);
            $user->occupation_area()->associate($occupation);
            $user->save();
            $this->res_status(201);
            return $user->toJson();
        } catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
            $this->abort(500);
        }
    }
    public function destroy()
    {
    }
}
