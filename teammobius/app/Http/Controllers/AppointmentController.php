<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Patient;
use App\Models\User; // To get a list of Doctors
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of all appointments (Admin/Doctor view).
     */
    public function index()
    {
        $appointments = Appointments::with(['patient', 'doctor'])
            ->orderBy('scheduled_at', 'desc')
            ->paginate(20);
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        $patients = Patient::orderBy('last_name')->get();
        // Fetch only users with the 'doctor' role
        $doctors = User::where('role', 'doctor')->orderBy('name')->get(); 
        
        return view('appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:users,id',
            'scheduled_at' => 'required|date|after_or_equal:now',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);
        
        // Doctor ID defaults to the logged-in user if not provided and the user is a doctor
        if (empty($validated['doctor_id']) && $request->user()->isDoctor()) {
            $validated['doctor_id'] = $request->user()->id;
        }

        Appointments::create($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    // ... Implement show(), edit(), update(), and destroy() methods

    /**
     * Show the currently logged-in patient's own appointments.
     */
    public function showPatientAppointments(Request $request)
    {
        $patient = $request->user()->patientData;
        if (!$patient) {
            return redirect()->route('dashboard')->with('error', 'Profile error.');
        }
        $appointments = $patient->appointments()->with('doctor')->orderBy('scheduled_at', 'desc')->get();
        return view('patient.appointments', compact('appointments'));
    }
}
