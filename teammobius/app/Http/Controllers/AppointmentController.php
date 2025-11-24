<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of all appointments (Admin/Doctor view).
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
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
            'doctor_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date|after_or_equal:now',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Check if the doctor is available at the scheduled time
        $isAvailable = $this->checkDoctorAvailability($validated['doctor_id'], $validated['scheduled_at']);
        
        if (!$isAvailable) {
            return back()->with('error', 'Doctor is not available at the selected time. Please choose another time.')->withInput();
        }

        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    /**
     * Display the patient appointment booking page with calendar and doctors
     */
    public function bookingIndex()
    {
        // Get available doctors with their specialties
        $doctors = User::where('role', 'doctor')
            ->with(['doctorProfile', 'availabilities' => function($query) {
                $query->where('date', '>=', now()->format('Y-m-d'))
                      ->where('is_available', true)
                      ->orderBy('date')
                      ->orderBy('start_time');
            }])
            ->get()
            ->map(function($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'specialty' => $doctor->doctorProfile->specialty ?? 'General Practitioner',
                    'image' => $doctor->doctorProfile->image ?? null,
                    'rating' => $doctor->doctorProfile->rating ?? 4.5,
                    'reviews_count' => $doctor->doctorProfile->reviews_count ?? 0,
                    'available_slots' => $doctor->availabilities->map(function($slot) {
                        return [
                            'date' => $slot->date,
                            'time' => $slot->start_time,
                            'datetime' => Carbon::parse($slot->date . ' ' . $slot->start_time)->format('Y-m-d H:i:s')
                        ];
                    })->toArray()
                ];
            });

        // Get current patient's appointments
        $patient = Auth::user()->patientData;
        $myAppointments = $patient ? $patient->appointments()
            ->with('doctor')
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->get()
            ->map(function($appointment) {
                return [
                    'id' => $appointment->id,
                    'doctor' => $appointment->doctor->name,
                    'specialty' => $appointment->doctor->doctorProfile->specialty ?? 'General Practitioner',
                    'date' => $appointment->scheduled_at->format('Y-m-d'),
                    'time' => $appointment->scheduled_at->format('H:i:s'),
                    'datetime' => $appointment->scheduled_at->format('Y-m-d H:i:s'),
                    'status' => $appointment->status,
                    'reason' => $appointment->reason
                ];
            })->toArray() : [];

        return view('booking.index', compact('doctors', 'myAppointments'));
    }

    /**
     * Book a new appointment from the patient booking page
     */
    public function bookAppointment(Request $request)
    {
        $patient = Auth::user()->patientData;
        
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile not found. Please complete your profile.'
            ], 422);
        }

        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date|after_or_equal:now',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        try {
            // Check if the selected slot is available
            $isAvailable = $this->checkDoctorAvailability($request->doctor_id, $request->scheduled_at);

            if (!$isAvailable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected time slot is no longer available. Please choose another time.'
                ], 422);
            }

            // Check if patient already has an appointment at this time
            $existingAppointment = Appointment::where('patient_id', $patient->id)
                ->where('scheduled_at', $request->scheduled_at)
                ->whereIn('status', [Appointment::STATUS_PENDING, Appointment::STATUS_CONFIRMED])
                ->exists();

            if ($existingAppointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have an appointment scheduled at this time.'
                ], 422);
            }

            // Create the appointment
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'scheduled_at' => $request->scheduled_at,
                'reason' => $request->reason,
                'notes' => $request->notes,
                'status' => Appointment::STATUS_PENDING,
            ]);

            // Mark the time slot as booked (if using Availability model)
            $this->markSlotAsBooked($request->doctor_id, $request->scheduled_at);

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully! You will receive a confirmation shortly.',
                'appointment_id' => $appointment->id
            ]);

        } catch (\Exception $e) {
            \Log::error('Appointment booking failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to book appointment. Please try again.'
            ], 500);
        }
    }

    /**
     * Cancel an appointment
     */
    public function cancelAppointment(Request $request, $id)
    {
        $patient = Auth::user()->patientData;
        
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile not found.'
            ], 422);
        }

        $appointment = Appointment::where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        if (!$appointment->canBeCancelled()) {
            return response()->json([
                'success' => false,
                'message' => 'Appointments can only be cancelled at least 24 hours in advance.'
            ], 422);
        }

        if ($appointment->isCancelled) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment is already cancelled.'
            ], 422);
        }

        try {
            \DB::transaction(function () use ($appointment, $request) {
                // Cancel the appointment
                $appointment->cancel($request->cancellation_reason);

                // Make the time slot available again
                $this->markSlotAsAvailable($appointment->doctor_id, $appointment->scheduled_at);
            });

            return response()->json([
                'success' => true,
                'message' => 'Appointment cancelled successfully.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Appointment cancellation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel appointment. Please try again.'
            ], 500);
        }
    }

    /**
     * Show the currently logged-in patient's own appointments.
     */
    public function showPatientAppointments(Request $request)
    {
        $patient = $request->user()->patientData;
        if (!$patient) {
            return redirect()->route('dashboard')->with('error', 'Profile error.');
        }
        
        $appointments = $patient->appointments()
            ->with('doctor')
            ->orderBy('scheduled_at', 'desc')
            ->get();
            
        return view('patient.appointments', compact('appointments'));
    }

    /**
     * Get available time slots for a specific doctor and date
     */
    public function getAvailableSlots($doctorId, $date)
    {
        $slots = Availability::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('is_available', true)
            ->where('date', '>=', now()->format('Y-m-d'))
            ->orderBy('start_time')
            ->get()
            ->map(function($slot) {
                return [
                    'time' => $slot->start_time,
                    'datetime' => Carbon::parse($slot->date . ' ' . $slot->start_time)->format('Y-m-d H:i:s'),
                    'formatted_time' => Carbon::parse($slot->start_time)->format('h:i A')
                ];
            });

        return response()->json([
            'success' => true,
            'slots' => $slots
        ]);
    }

    /**
     * Get calendar data for a specific month
     */
    public function getCalendarData($year, $month)
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Get all available dates for any doctor in this month
        $availableDates = Availability::whereBetween('date', [
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d')
        ])
        ->where('is_available', true)
        ->distinct()
        ->pluck('date')
        ->toArray();

        return response()->json([
            'success' => true,
            'available_dates' => $availableDates
        ]);
    }

    /**
     * Check if a doctor is available at a specific datetime
     */
    private function checkDoctorAvailability($doctorId, $scheduledAt)
    {
        $date = Carbon::parse($scheduledAt)->format('Y-m-d');
        $time = Carbon::parse($scheduledAt)->format('H:i:s');

        return Availability::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('start_time', $time)
            ->where('is_available', true)
            ->exists();
    }

    /**
     * Mark a time slot as booked
     */
    private function markSlotAsBooked($doctorId, $scheduledAt)
    {
        $date = Carbon::parse($scheduledAt)->format('Y-m-d');
        $time = Carbon::parse($scheduledAt)->format('H:i:s');

        Availability::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('start_time', $time)
            ->update(['is_available' => false]);
    }

    /**
     * Mark a time slot as available
     */
    private function markSlotAsAvailable($doctorId, $scheduledAt)
    {
        $date = Carbon::parse($scheduledAt)->format('Y-m-d');
        $time = Carbon::parse($scheduledAt)->format('H:i:s');

        Availability::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('start_time', $time)
            ->update(['is_available' => true]);
    }

    /**
     * Show appointment details
     */
    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'doctor'])
            ->findOrFail($id);
            
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Edit appointment form
     */
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $patients = Patient::orderBy('last_name')->get();
        $doctors = User::where('role', 'doctor')->orderBy('name')->get();
        
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update appointment
     */
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'scheduled_at' => 'required|date|after_or_equal:now',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    /**
     * Delete appointment
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
