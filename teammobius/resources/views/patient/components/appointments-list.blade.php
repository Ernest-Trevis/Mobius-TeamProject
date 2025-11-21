<div class="card mb-4 shadow-sm">
    <div class="card-header bg-success text-white">My Appointments</div>
    <div class="card-body">

        @foreach($appointments as $appt)
            <div class="p-3 mb-2 border rounded d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $appt['doctor'] }}</strong><br>
                    <small class="text-muted">{{ $appt['date'] }}</small>
                </div>

                <span class="badge 
                    {{ $appt['status']=='pending' ? 'bg-warning' : 'bg-info' }} 
                    text-dark py-2 px-3">
                    {{ ucfirst($appt['status']) }}
                </span>
            </div>
        @endforeach

    </div>
</div>
