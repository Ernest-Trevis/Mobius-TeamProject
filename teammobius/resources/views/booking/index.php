@extends('layouts.patient')

@section('content')
@php
    $availableDoctors = [
        [
            'id' => 1,
            'name' => 'Dr. Sarah Kimani',
            'specialty' => 'General Physician',
            'image' => 'doctor1.jpg',
            'rating' => 4.8,
            'reviews' => 127,
            'available_slots' => [
                ['date' => '2025-01-15', 'time' => '09:00 AM'],
                ['date' => '2025-01-15', 'time' => '10:30 AM'],
                ['date' => '2025-01-16', 'time' => '02:00 PM'],
                ['date' => '2025-01-17', 'time' => '11:00 AM']
            ]
        ],
        [
            'id' => 2,
            'name' => 'Dr. Michael Achieng',
            'specialty' => 'Dentist',
            'image' => 'doctor2.jpg',
            'rating' => 4.9,
            'reviews' => 89,
            'available_slots' => [
                ['date' => '2025-01-15', 'time' => '01:00 PM'],
                ['date' => '2025-01-16', 'time' => '09:30 AM'],
                ['date' => '2025-01-18', 'time' => '03:00 PM']
            ]
        ],
        [
            'id' => 3,
            'name' => 'Dr. Grace Wambui',
            'specialty' => 'Cardiologist',
            'image' => 'doctor3.jpg',
            'rating' => 4.7,
            'reviews' => 156,
            'available_slots' => [
                ['date' => '2025-01-16', 'time' => '10:00 AM'],
                ['date' => '2025-01-17', 'time' => '02:30 PM'],
                ['date' => '2025-01-19', 'time' => '11:30 AM']
            ]
        ],
        [
            'id' => 4,
            'name' => 'Dr. James Omondi',
            'specialty' => 'Dermatologist',
            'image' => 'doctor4.jpg',
            'rating' => 4.6,
            'reviews' => 94,
            'available_slots' => [
                ['date' => '2025-01-15', 'time' => '03:00 PM'],
                ['date' => '2025-01-18', 'time' => '10:00 AM'],
                ['date' => '2025-01-19', 'time' => '01:30 PM']
            ]
        ],
        [
            'id' => 5,
            'name' => 'Dr. Mary Njeri',
            'specialty' => 'Pediatrician',
            'image' => 'doctor5.jpg',
            'rating' => 4.9,
            'reviews' => 203,
            'available_slots' => [
                ['date' => '2025-01-16', 'time' => '08:30 AM'],
                ['date' => '2025-01-17', 'time' => '11:00 AM'],
                ['date' => '2025-01-20', 'time' => '02:00 PM']
            ]
        ],
        [
            'id' => 6,
            'name' => 'Dr. Robert Mutiso',
            'specialty' => 'Orthopedic Surgeon',
            'image' => 'doctor6.jpg',
            'rating' => 4.5,
            'reviews' => 78,
            'available_slots' => [
                ['date' => '2025-01-17', 'time' => '09:00 AM'],
                ['date' => '2025-01-19', 'time' => '03:30 PM'],
                ['date' => '2025-01-20', 'time' => '10:30 AM']
            ]
        ],
        [
            'id' => 7,
            'name' => 'Dr. Elizabeth Kamau',
            'specialty' => 'Gynecologist',
            'image' => 'doctor7.jpg',
            'rating' => 4.8,
            'reviews' => 145,
            'available_slots' => [
                ['date' => '2025-01-18', 'time' => '01:00 PM'],
                ['date' => '2025-01-19', 'time' => '09:30 AM'],
                ['date' => '2025-01-21', 'time' => '11:00 AM']
            ]
        ],
        [
            'id' => 8,
            'name' => 'Dr. David Otieno',
            'specialty' => 'Neurologist',
            'image' => 'doctor8.jpg',
            'rating' => 4.7,
            'reviews' => 112,
            'available_slots' => [
                ['date' => '2025-01-19', 'time' => '02:00 PM'],
                ['date' => '2025-01-20', 'time' => '10:00 AM'],
                ['date' => '2025-01-21', 'time' => '03:00 PM']
            ]
        ]
    ];

    $myAppointments = [
        [
            'id' => 1,
            'doctor' => 'Dr. Sarah Kimani',
            'specialty' => 'General Physician',
            'date' => '2025-01-15',
            'time' => '09:00 AM',
            'status' => 'confirmed'
        ],
        [
            'id' => 2,
            'doctor' => 'Dr. Michael Achieng',
            'specialty' => 'Dentist',
            'date' => '2025-01-25',
            'time' => '11:00 AM',
            'status' => 'pending'
        ],
        [
            'id' => 3,
            'doctor' => 'Dr. Grace Wambui',
            'specialty' => 'Cardiologist',
            'date' => '2025-02-01',
            'time' => '02:30 PM',
            'status' => 'confirmed'
        ]
    ];
@endphp

<style>
    /* Custom Styles for Appointment Booking */
    .appointment-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .section-title {
        color: #002147;
        font-weight: 700;
        margin-bottom: 24px;
        border-bottom: 2px solid #3B82F6;
        padding-bottom: 8px;
    }

    .doctor-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-left: 4px solid #3B82F6;
    }

    .doctor-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .doctor-header {
        display: flex;
        align-items: center;
        margin-bottom: 16px;
    }

    .doctor-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        font-weight: bold;
        color: #3B82F6;
    }

    .doctor-info {
        flex: 1;
    }

    .doctor-name {
        font-weight: 600;
        color: #002147;
        margin-bottom: 4px;
    }

    .doctor-specialty {
        color: #64748b;
        font-size: 0.9em;
    }

    .doctor-rating {
        display: flex;
        align-items: center;
        color: #f59e0b;
        font-size: 0.9em;
    }

    .available-slots {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
        margin-top: 16px;
    }

    .slot-btn {
        background: #10B981;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 0.85em;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .slot-btn:hover {
        background: #059669;
    }

    .calendar-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 30px;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }

    .calendar-day {
        text-align: center;
        font-weight: 600;
        color: #64748b;
        padding: 8px;
    }

    .calendar-date {
        text-align: center;
        padding: 12px 8px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .calendar-date:hover {
        background: #e2e8f0;
    }

    .calendar-date.selected {
        background: #3B82F6;
        color: white;
    }

    .calendar-date.available {
        background: #d1fae5;
        color: #065f46;
    }

    .appointment-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 16px;
        border-left: 4px solid;
    }

    .appointment-card.confirmed {
        border-left-color: #10B981;
    }

    .appointment-card.pending {
        border-left-color: #f59e0b;
    }

    .appointment-card.cancelled {
        border-left-color: #ef4444;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8em;
        font-weight: 600;
    }

    .status-confirmed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-primary {
        background: #3B82F6;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.2s ease;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 1000;
        animation: slideIn 0.3s ease;
    }

    .notification.success {
        background: #10B981;
    }

    .notification.error {
        background: #ef4444;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1001;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        padding: 30px;
        border-radius: 12px;
        max-width: 500px;
        width: 90%;
    }

    .tabs {
        display: flex;
        margin-bottom: 24px;
        border-bottom: 1px solid #e2e8f0;
    }

    .tab {
        padding: 12px 24px;
        cursor: pointer;
        border-bottom: 3px solid transparent;
    }

    .tab.active {
        border-bottom-color: #3B82F6;
        color: #3B82F6;
        font-weight: 600;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }
</style>

<div class="appointment-container">
    <h2 class="section-title">Book an Appointment</h2>

    <!-- Tabs Navigation -->
    <div class="tabs">
        <div class="tab active" onclick="switchTab('book')">Book New Appointment</div>
        <div class="tab" onclick="switchTab('my-appointments')">My Appointments</div>
    </div>

    <!-- Book Appointment Tab -->
    <div id="book-tab" class="tab-content active">
        <!-- Calendar Section -->
        <div class="calendar-container">
            <div class="calendar-header">
                <h3 style="color:#002147; margin:0;">Select a Date</h3>
                <div>
                    <button onclick="changeMonth(-1)" class="btn-primary" style="padding: 8px 12px; margin-right: 8px;">← Prev</button>
                    <span id="current-month" style="font-weight:600;">January 2025</span>
                    <button onclick="changeMonth(1)" class="btn-primary" style="padding: 8px 12px; margin-left: 8px;">Next →</button>
                </div>
            </div>
            <div class="calendar-grid" id="calendar-days">
                <!-- Calendar days will be populated by JavaScript -->
            </div>
        </div>

        <!-- Available Doctors Section -->
        <h3 class="section-title">Available Doctors</h3>
        <div id="doctors-list">
            @foreach($availableDoctors as $doctor)
            <div class="doctor-card" data-doctor-id="{{ $doctor['id'] }}">
                <div class="doctor-header">
                    <div class="doctor-avatar">
                        {{ substr($doctor['name'], 0, 1) }}{{ substr(strstr($doctor['name'], ' '), 1, 1) }}
                    </div>
                    <div class="doctor-info">
                        <div class="doctor-name">{{ $doctor['name'] }}</div>
                        <div class="doctor-specialty">{{ $doctor['specialty'] }}</div>
                        <div class="doctor-rating">
                            ⭐ {{ $doctor['rating'] }} ({{ $doctor['reviews'] }} reviews)
                        </div>
                    </div>
                </div>
                <div class="available-slots">
                    @foreach($doctor['available_slots'] as $slot)
                    <button class="slot-btn" 
                            data-doctor="{{ $doctor['name'] }}"
                            data-specialty="{{ $doctor['specialty'] }}"
                            data-date="{{ $slot['date'] }}"
                            data-time="{{ $slot['time'] }}"
                            onclick="bookAppointment(this)">
                        {{ \Carbon\Carbon::parse($slot['date'])->format('M j') }} - {{ $slot['time'] }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- My Appointments Tab -->
    <div id="my-appointments-tab" class="tab-content">
        <h3 class="section-title">My Appointments</h3>
        
        @if(count($myAppointments) > 0)
            @foreach($myAppointments as $appt)
            <div class="appointment-card {{ $appt['status'] }}">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <div>
                        <h4 style="margin: 0 0 8px 0; color: #002147;">{{ $appt['doctor'] }}</h4>
                        <p style="margin: 0 0 4px 0; color: #64748b;">{{ $appt['specialty'] }}</p>
                        <p style="margin: 0; font-weight: 500;">
                            {{ \Carbon\Carbon::parse($appt['date'])->format('F j, Y') }} at {{ $appt['time'] }}
                        </p>
                    </div>
                    <span class="status-badge status-{{ $appt['status'] }}">
                        {{ ucfirst($appt['status']) }}
                    </span>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 16px;">
                    <a href="/patient/appointments/{{ $appt['id'] }}" class="btn-primary">View Details</a>
                    @if($appt['status'] != 'cancelled')
                    <button class="btn-danger" onclick="cancelAppointment({{ $appt['id'] }})">Cancel Appointment</button>
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <div style="text-align: center; padding: 40px; color: #64748b;">
                <p>No appointments booked yet.</p>
                <button class="btn-primary" onclick="switchTab('book')">Book Your First Appointment</button>
            </div>
        @endif
    </div>
</div>

<!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="modal">
    <div class="modal-content">
        <h3 style="color:#002147; margin-bottom:16px;">Cancel Appointment</h3>
        <p>Are you sure you want to cancel this appointment?</p>
        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button class="btn-danger" onclick="confirmCancellation()">Yes, Cancel</button>
            <button class="btn-primary" onclick="closeModal()" style="background: #64748b;">No, Keep It</button>
        </div>
    </div>
</div>

<script>
    let currentMonth = 0; // January 2025
    let selectedDate = null;
    let appointmentToCancel = null;

    // Tab switching functionality
    function switchTab(tabName) {
        // Update tabs
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        event.target.classList.add('active');
        document.getElementById(tabName + '-tab').classList.add('active');
    }

    // Calendar functionality
    function generateCalendar() {
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];
        
        const currentDate = new Date(2025, currentMonth, 1);
        document.getElementById('current-month').textContent = 
            `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

        const calendarDays = document.getElementById('calendar-days');
        calendarDays.innerHTML = '';

        // Add day headers
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        days.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = day;
            calendarDays.appendChild(dayElement);
        });

        // Get first day of month and total days
        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
        const totalDays = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

        // Add empty cells for days before first day of month
        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'calendar-date';
            calendarDays.appendChild(emptyCell);
        }

        // Add days of the month
        for (let day = 1; day <= totalDays; day++) {
            const dateElement = document.createElement('div');
            dateElement.className = 'calendar-date';
            dateElement.textContent = day;
            
            const dateString = `2025-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            dateElement.setAttribute('data-date', dateString);

            // Mark available dates (for demo, mark some dates as available)
            if (Math.random() > 0.3) {
                dateElement.classList.add('available');
            }

            dateElement.addEventListener('click', function() {
                selectDate(this);
            });

            calendarDays.appendChild(dateElement);
        }
    }

    function selectDate(element) {
        document.querySelectorAll('.calendar-date').forEach(date => {
            date.classList.remove('selected');
        });
        element.classList.add('selected');
        selectedDate = element.getAttribute('data-date');
        
        // Filter doctors by selected date
        filterDoctorsByDate(selectedDate);
    }

    function filterDoctorsByDate(date) {
        const doctors = document.querySelectorAll('.doctor-card');
        doctors.forEach(doctor => {
            const slots = doctor.querySelectorAll('.slot-btn');
            let hasSlot = false;
            
            slots.forEach(slot => {
                if (slot.getAttribute('data-date') === date) {
                    hasSlot = true;
                }
            });
            
            doctor.style.display = hasSlot ? 'block' : 'none';
        });
    }

    function changeMonth(direction) {
        currentMonth += direction;
        if (currentMonth < 0) currentMonth = 11;
        if (currentMonth > 11) currentMonth = 0;
        generateCalendar();
    }

    // Appointment booking functionality
    function bookAppointment(button) {
        const doctor = button.getAttribute('data-doctor');
        const specialty = button.getAttribute('data-specialty');
        const date = button.getAttribute('data-date');
        const time = button.getAttribute('data-time');

        // In a real application, you would send this data to the server
        showNotification(`Appointment booked with ${doctor} on ${date} at ${time}`, 'success');
        
        // Simulate adding to appointments list
        setTimeout(() => {
            switchTab('my-appointments');
        }, 2000);
    }

    function cancelAppointment(appointmentId) {
        appointmentToCancel = appointmentId;
        document.getElementById('cancelModal').style.display = 'flex';
    }

    function confirmCancellation() {
        if (appointmentToCancel) {
            showNotification('Appointment cancelled successfully', 'success');
            closeModal();
            
            // In a real application, you would send a request to the server to cancel the appointment
            setTimeout(() => {
                // Reload or update the appointments list
                location.reload();
            }, 1500);
        }
    }

    function closeModal() {
        document.getElementById('cancelModal').style.display = 'none';
        appointmentToCancel = null;
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Initialize calendar on page load
    document.addEventListener('DOMContentLoaded', function() {
        generateCalendar();
    });
</script>

@endsection
