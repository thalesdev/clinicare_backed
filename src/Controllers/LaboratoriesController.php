<?php

namespace Clinicare\Controllers;

use Clinicare\Models\User;
use Clinicare\Models\Address;
use Clinicare\Models\ExamType;
use Clinicare\Models\Laboratory;
use Exception;

class LaboratoriesController extends Controller
{

    public function index()
    {
        return User::with([
            'laboratory',
            'laboratory.exam_types'
        ])->where('type', 1)->get()->toJson();
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
            'crm',
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

        $laboratory_input = $this->inputsWithKeys([
            "cnpj",
            "cnes",
            "iss",
            "employees"
        ]);

        try {
            $user = User::create(array_merge(
                $user_input,
                [
                    "password" => md5($this->input("password") || 'senha123'),
                    "type" => 1
                ]
            ));
            $address = Address::create($address_input);
            $laboratory = Laboratory::create(array_merge(
                $laboratory_input,
                ['user_id' => $user->id]
            ));

            foreach ($this->input('types') as $type) {
                $type_m = ExamType::firstOrCreate([
                    "name" => $type
                ]);
                $laboratory->exam_types()->save($type_m);
            }

            $user->address()->associate($address);
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
