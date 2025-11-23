<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Show the form for creating a new medical record for a specific patient.
     */
    public function create(Patient $patient)
    {
        // This view will contain the form to add a new record to $patient
        return view('medical_records.create', compact('patient'));
    }

    /**
     * Store a newly created medical record for a specific patient.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'visit_date' => 'required|date',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment' => 'nullable|string',
        ]);

        // Create the record, linking it to the patient and the doctor (logged-in user)
        $record = $patient->medicalRecords()->create([
            'user_id' => $request->user()->id, // The doctor creating the record
            ...$validated,
        ]);

        return redirect()->route('patients.show', $patient)->with('success', 'Medical Record created successfully.');
    }
    
    // ... Implement show(), edit(), update(), and destroy() methods

    /**
     * Show the currently logged-in patient's own medical records.
     */
    public function showPatientRecords(Request $request)
    {
        $patient = $request->user()->patientData;
        if (!$patient) {
            return redirect()->route('dashboard')->with('error', 'Profile error.');
        }
        $records = $patient->medicalRecords()->with(['doctor', 'prescriptions'])->orderBy('visit_date', 'desc')->get();
        return view('patient.records', compact('records'));
    }
}