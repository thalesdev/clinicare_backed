<?php

/**
 * Clinicare backend v2
 */

error_reporting(E_ALL);

require_once "Routes/index.php";

require_once __DIR__ . "/cors.php";


use Clinicare\Database\Database;
use Clinicare\Models\User;
use Clinicare\Routes\Router;

// use Clinicare\Models\User;
// use Clinicare\Models\Address;
// use Clinicare\Models\Appointment;
// use Clinicare\Models\Exam;
// use Clinicare\Models\OccupationArea;
use Clinicare\Models\ExamType;
// use Clinicare\Models\Laboratory;

// habilita o cors
cors();

// instancia nossa base de dados
Database::boot();



// echo json_encode($_SERVER);


$router = Router::getInstance();
$router->listen();



// User::create([
//     "name" => "fodace",
//     "email" => "fodace@live3.com",
//     "password" => "fodace@2",
//     "phone" => "fodac",
//     "type" => 3
// ]);


// $lab = Laboratory::with('exams')->find(1);
// $patient = User::with('exams')->find(3);
// $doctor = User::find(4);


// $appointment = new Exam;
// $appointment->patient()->associate($patient);
// $appointment->laboratory()->associate($lab);
// $appointment->save();
// first form

// echo $lab;



// $payload1 = [
//     'name' => 'tipo teste',
// ];
// $payload2 = [
//     "cnpj" => "416464646",
//     "cnes" => "5464646464",
//     "iss" => "54664646",
//     "employees" => "687",
//     "user_id" => $user->id
// ];



// $model = Laboratory::create($payload2);
// $model->user()->associate($user)->save();
// $type = ExamType::create($payload1);
// $model->types()->save($type);


// $lab = Laboratory::with('exam_types')->find(1);
// // $type = ExamType::find(1);
// // echo $type;
// // echo $type->laboratories()->save($lab);
// echo $lab->toJson();

// echo User::with('lab')->find(1);
