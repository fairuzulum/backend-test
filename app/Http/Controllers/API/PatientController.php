<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{

    public function index()
    {
        $patients = Patient::withCount('visits')->orderBy('created_at', 'asc')->get();


        return response()->json([
            'message' => 'Successfully retrieved all patients.',
            'data' => $patients
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|min:16|max:16',
            'patient_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lastPatient = Patient::orderBy('id', 'desc')->first();
        $lastId = $lastPatient ? $lastPatient->id : 0;
        $numberRecordMedik = 'RM' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);


        $patient = Patient::create([
            'number_record_medik' => $numberRecordMedik,
            'nik' => $request->nik, 
            'patient_name' => $request->patient_name,
            'address' => $request->address,
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => 'Patient registered successfully.',
            'data' => $patient
        ], 201);
    }

    public function show(string $number_record_medik)
    {
        $patient = Patient::withCount('visits')->where('number_record_medik', $number_record_medik)->first();

        if (!$patient) {
            return response()->json(['message' => 'Patient not found.'], 404);
        }

        return response()->json([
            'message' => 'Successfully retrieved patient data.',
            'data' => $patient
        ]);
    }
}
