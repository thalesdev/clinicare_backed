<?php

namespace Clinicare\Controllers;

use Clinicare\Auth;
use Clinicare\Models\Appointment;
use Clinicare\Models\User;
use Exception;

class AppointmentsController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user->type === 2) {
            $payload =  $user->patient_appointments()->get();
        } else if ($user->type === 3) {
            $payload = $user->doctor_appointments()->get();
        } else {
            $this->abort(400);
        }

        if ($payload)
            return $payload->toJson();
        return json_encode([]);
    }

    public function show()
    {
        $id = $this->arg("id");
        $user = Auth::user();

        $appointment = Appointment::find($id);
        if (!$appointment)   $this->abort(400);

        if ($user->type === 2) {
            $constrait = $appointment->patient_id === $user->id;
        } else if ($user->type === 3) {
            $constrait = $appointment->doctor_id === $user->id;
        } else {
            $constrait = false;
        }
        if ($constrait) return $appointment->toJson();
        $this->abort(403);
    }
    public function store()
    {

        $schedule = $this->input("schedule");
        $observation = $this->input("observation");
        $prescription = $this->input("prescription");

        $user = Auth::user();

        $appointment = new Appointment;
        $appointment->schedule = $schedule;
        $appointment->observation = $observation;
        $appointment->prescription = $prescription;
        if ($user->type === 2) {
            $appointment->patient()->associate($user);
            $doctor = User::find($this->input('doctor_id'));
            if (!$doctor) $this->abort(403);
            if ($doctor->type !== 3) $this->abort(403);
            $appointment->doctor()->associate($doctor);
        } else if ($user->type === 3) {
            $patient = User::find($this->input('patient_id'));
            if (!$patient) $this->abort(403);
            if ($patient->type !== 2) $this->abort(403);
            $appointment->patient()->associate($patient);
            $appointment->doctor()->associate($user);
        } else {
            $this->abort(400);
        }
        try {
            $appointment->save();
            $this->res_status(201);
            return $appointment->toJson();
        } catch (Exception $e) {
            print_r($e->getMessage());
            $this->abort(403);
        }
    }
    public function destroy()
    {
        $id = $this->arg("id");
        $user = Auth::user();

        $appointment = Appointment::find($id);
        if (!$appointment)   $this->abort(400);

        if ($user->type === 3) {
            $constrait = $appointment->doctor_id === $user->id;
        } else {
            $constrait = false;
        }
        if ($constrait) {
            return $appointment->delete();
        }
        $this->abort(403);
    }
}
