<div class="card mb-4 shadow-sm fade-in">
  <div class="card-header bg-success text-white">My Appointments</div>
  <div class="card-body">
    @foreach($appointments as $appt)
      <div class="d-flex justify-content-between align-items-center p-3 mb-2 border rounded">
        <div>
          <div class="fw-bold">{{ $appt['doctor'] }}</div>
          <div class="text-muted small">{{ $appt['date'] }}</div>
        </div>

        <div class="text-end">
          <div>
            <span class="badge-status {{ $appt['status']=='pending' ? 'bg-warning text-dark' : 'bg-info text-dark' }}">
              {{ ucfirst($appt['status']) }}
            </span>
          </div>
          <div class="mt-2">
            <a class="btn btn-sm btn-outline-primary" href="/patient/appointments/1">Details</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
