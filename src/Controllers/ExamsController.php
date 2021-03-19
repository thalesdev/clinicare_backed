<?php

namespace Clinicare\Controllers;

use Carbon\Carbon;
use Clinicare\Auth;
use Clinicare\Models\Exam;
use Clinicare\Models\ExamType;
use Clinicare\Models\Laboratory;
use Clinicare\Models\User;
use Exception;

class ExamsController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $with = [
            'patient',
            'laboratory',
            'laboratory.user'
        ];
        $order = $_GET['order'] ?? 0;

        if ($user->type === 2) {
            $payload =  $user->exams()->with($with);
        } else if ($user->type === 1) {
            $payload =  $user->laboratory()->first()->exams()->with($with);
        } else if ($user->type === 5) {
            $payload = Exam::with($with);
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

        $exam = Exam::find($id);
        if (!$exam)   $this->abort(400);
        if ($user->type === 2) {
            $constrait = $exam->user_id === $user->id;
        } else if ($user->type === 1) {
            $constrait = $exam->laboratory_id === $user->id;
        } else if ($user->type === 5) {
            $constrait = true; // adm
        } else {
            $constrait = false;
        }
        if ($constrait) return $exam->toJson();
        $this->abort(403);
    }
    public function store()
    {

        $schedule = $this->input("schedule");
        $result = $this->input("result") ?? "Não definido";
        $type = $this->input("exam_type_id");

        $user = Auth::user();

        $exam_type = ExamType::find($type);
        if (!$exam_type) $this->abort(400);

        $exam = new Exam;
        $exam->schedule = $schedule;
        $exam->result = $result;
        // $exam->exam_type = $exam_type;

        if ($user->type === 2) {
            $exam->patient()->associate($user);
            $laboratory = Laboratory::find($this->input('laboratory_id'));
            if (!$laboratory) $this->abort(403);
            $exam->laboratory()->associate($laboratory);
        } else if ($user->type === 1) {
            $patient = User::find($this->input('patient_id'));
            if (!$patient) $this->abort(403);
            if ($patient->type !== 2) $this->abort(403);
            $exam->patient()->associate($patient);
            $exam->laboratory()->associate($user->laboratory()->first());
        } else if ($user->type === 5) {
            $patient = User::find($this->input('patient_id'));
            $laboratory = Laboratory::find($this->input('laboratory_id'));
            if (!$laboratory || !$patient) $this->abort(403, [
                "patient" => $patient,
                "laboratory" => $laboratory
            ]);
            $exam->patient()->associate($patient);
            $exam->laboratory()->associate($laboratory);
        } else {
            $this->abort(400);
        }
        try {
            $exam->save();
            $this->res_status(201);
            return $exam->toJson();
        } catch (Exception $e) {
            print_r($e->getMessage());
            $this->abort(403);
        }
    }
    public function destroy()
    {
        $id = $this->arg("id");
        $user = Auth::user();

        $exam = Exam::find($id);
        if (!$exam)   $this->abort(400);

        if ($user->type === 1) {
            $constrait = $exam->doctor_id === $user->id;
        } else if ($user->type === 5) {
            $constrait = true;
        } else {
            $constrait = false;
        }
        if ($constrait) {
            return $exam->delete();
        }
        $this->abort(403);
    }
}
