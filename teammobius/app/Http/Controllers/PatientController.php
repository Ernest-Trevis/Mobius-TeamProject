<?php
namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    /**
     * Display a listing of all patients. (R - Read)
     */
    public function index()
    {
        // Fetch all patients and their associated user login details
        $patients = Patient::with('user')->orderBy('last_name')->paginate(15);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient record and user account. (C - Create)
     */
    public function create()
    {
        // This view will contain the form for the user and patient details.
        return view('patients.create');
    }

    /**
     * Store a newly created patient account and medical record. (C - Create)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // User Validation
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Patient Validation
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => ['nullable', Rule::in(['Male', 'Female', 'Other'])],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        // 1. Create the User Account (Role is set to 'patient' by default in the migration)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'patient', // Explicitly set role
        ]);

        // 2. Create the linked Patient Medical Record
        $patient = Patient::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient account and record created successfully!');
    }

    /**
     * Display the specified patient profile with their records and appointments. (R - Read)
     */
    public function show(Patient $patient)
    {
        // Eager load relationships for the profile view
        $patient->load(['appointments' => function($query) {
            $query->latest('scheduled_at');
        }, 'medicalRecords' => function($query) {
            $query->latest('visit_date')->with('prescriptions', 'doctor');
        }]);

        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified patient record. (U - Update)
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient record. (U - Update)
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            // Update patient details (User details would typically be updated separately)
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => ['nullable', Rule::in(['Male', 'Female', 'Other'])],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient)->with('success', 'Patient record updated successfully.');
    }

    /**
     * Remove the specified patient record and associated user account. (D - Delete)
     */
    public function destroy(Patient $patient)
    {
        // Because of the 'onDelete('cascade')' constraint on the user_id foreign key 
        // in the patients table, deleting the associated User will automatically delete the Patient record.
        $user = $patient->user;
        $user->delete();

        return redirect()->route('patients.index')->with('success', 'Patient and associated account deleted.');
    }

    // --- Patient-Specific View (For logged-in 'patient' role) ---
    /**
     * Displays the currently logged-in patient's own profile.
     */
    public function showPatientProfile(Request $request)
    {
        $patient = $request->user()->patientData;
        if (!$patient) {
             // Handle case where user is logged in but has no patient profile (e.g., Doctor/Admin)
            return redirect()->route('dashboard')->with('error', 'You do not have a patient profile.');
        }
        $patient->load(['appointments', 'medicalRecords.prescriptions']);
        return view('patient.profile', compact('patient'));
    }
}