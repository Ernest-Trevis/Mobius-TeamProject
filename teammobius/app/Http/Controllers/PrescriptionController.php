<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the prescriptions.
     */
    public function index()
    {
        // Get all prescriptions with their related medical records and patients
        $prescriptions = Prescription::with(['medicalRecord.patient'])
            ->latest()
            ->get();

        // Get all patients for the patient selection dropdown
        $patients = Patient::with('medicalRecords')
            ->latest()
            ->get();

        return view('prescriptions.index', compact('prescriptions', 'patients'));
    }

    /**
     * Show the form for creating a new prescription.
     */
    public function create()
    {
        // Get medical records for dropdown (if needed for separate create page)
        $medicalRecords = MedicalRecord::with('patient')->get();
        return view('prescriptions.create', compact('medicalRecords'));
    }

    /**
     * Store a newly created prescription in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'medication_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'instructions' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $prescription = Prescription::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Prescription created successfully!',
            'prescription' => $prescription->load('medicalRecord.patient')
        ], 201);
    }

    /**
     * Display the specified prescription.
     */
    public function show(Prescription $prescription)
    {
        $prescription->load(['medicalRecord.patient']);
        return view('prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for editing the specified prescription.
     */
    public function edit(Prescription $prescription)
    {
        $prescription->load(['medicalRecord.patient']);
        $medicalRecords = MedicalRecord::with('patient')->get();
        
        return view('prescriptions.edit', compact('prescription', 'medicalRecords'));
    }

    /**
     * Update the specified prescription in storage.
     */
    public function update(Request $request, Prescription $prescription)
    {
        $validated = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'medication_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'instructions' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $prescription->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Prescription updated successfully!',
            'prescription' => $prescription->load('medicalRecord.patient')
        ]);
    }

    /**
     * Remove the specified prescription from storage.
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prescription deleted successfully!'
        ]);
    }

    /**
     * Get prescriptions by medical record ID
     */
    public function getByMedicalRecord($medicalRecordId)
    {
        $prescriptions = Prescription::with(['medicalRecord.patient'])
            ->where('medical_record_id', $medicalRecordId)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'prescriptions' => $prescriptions
        ]);
    }

    /**
     * Get prescriptions by patient ID
     */
    public function getByPatient($patientId)
    {
        // Assuming MedicalRecord has patient_id foreign key
        $prescriptions = Prescription::with(['medicalRecord.patient'])
            ->whereHas('medicalRecord', function($query) use ($patientId) {
                $query->where('patient_id', $patientId);
            })
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'prescriptions' => $prescriptions
        ]);
    }
}
