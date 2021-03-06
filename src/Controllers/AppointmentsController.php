<?php

namespace Clinicare\Controllers;

use Carbon\Carbon;
use Clinicare\Auth;
use Clinicare\Models\Appointment;
use Clinicare\Models\User;
use Exception;

class AppointmentsController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $with = [
            'doctor',
            'patient'
        ];
        $order = $_GET['order'] ?? 0;
        if ($user->type === 2) {
            $payload =  $user->patient_appointments()->with($with);
        } else if ($user->type === 3) {
            $payload = $user->doctor_appointments()->with($with);
        } else if ($user->type === 5) {
            $payload = Appointment::with($with); // admin
        } else {
            $this->abort(400);
        }

        switch (intval($order)) {
            case 0:
                $payload = $payload->get();
                break;
            case 1:
                $payload  = $payload->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->get();
                break;
            case 2:
                $payload  = $payload->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
                break;

            case 3:
                $payload  = $payload->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
                break;
            case 4:
                $payload  = $payload->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();
                break;
            default:
                $payload = $payload->get();
                break;
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
        } else if ($user->type === 5) {
            $constrait = true;
        } else {
            $constrait = false;
        }
        if ($constrait) return $appointment->toJson();
        $this->abort(403);
    }
    public function store()
    {

        $schedule = $this->input("schedule");
        $observation = $this->input("observation") ?? "N??o definido";
        $prescription = $this->input("prescription") ?? "N??o definido";

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
        } else if ($user->type === 5) {
            $patient = User::find($this->input('patient_id'));
            $doctor = User::find($this->input('doctor_id'));
            if (!$patient || !$doctor) $this->abort(403);
            if ($patient->type !== 2 || $doctor->type !== 3) $this->abort(403);
            $appointment->patient()->associate($patient);
            $appointment->doctor()->associate($doctor);
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
        } else if ($user->ype === 5) {
            $constrait = true;
        } else {
            $constrait = false;
        }
        if ($constrait) {
            return $appointment->delete();
        }
        $this->abort(403);
    }
}
