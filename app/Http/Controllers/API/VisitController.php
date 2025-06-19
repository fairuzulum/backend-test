<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{
 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number_record_medik' => 'required|string|exists:patients,number_record_medik',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patient = Patient::where('number_record_medik', $request->number_record_medik)->firstOrFail();

        $patient->visits()->create([]);

        $totalVisits = $patient->visits()->count();

        return response()->json([
            'message' => 'Visit has been successfully recorded.',
            'patient_name' => $patient->patient_name,
            'number_record_medik' => $patient->number_record_medik,
            'total_visits' => $totalVisits,
        ], 201);
    }
}