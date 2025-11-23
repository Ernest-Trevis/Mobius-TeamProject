<div id="appointmentForm" class="card mb-4 shadow-sm fade-in">
  <div class="card-header bg-primary text-white">Book Appointment</div>
  <div class="card-body">
    <form aria-label="Book an appointment (UI only)">
      <div class="mb-3">
        <label class="form-label">Choose Doctor</label>
        <select class="form-select" aria-label="Select doctor">
          @foreach($doctors as $doc)
            <option value="{{ $doc['name'] }}">{{ $doc['name'] }} — {{ $doc['specialization'] }}</option>
          @endforeach
        </select>
      </div>

      <div class="row g-2 mb-3">
        <div class="col-12 col-md-6">
          <label class="form-label">Choose Date</label>
          <input type="date" class="form-control" aria-label="Choose appointment date">
        </div>
        <div class="col-12 col-md-6">
          <label class="form-label">Choose Time</label>
          <input type="time" class="form-control" aria-label="Choose appointment time">
        </div>
      </div>

      <div class="d-grid">
        <button type="button" class="btn btn-primary" id="bookBtn">
          <i class="bi bi-plus-circle me-1"></i> Book Appointment
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  // temporary front-end behaviour to show a toast confirming action
  document.addEventListener('click', function(e){
    if (e.target && e.target.id === 'bookBtn') {
      e.preventDefault();
      showToast('Booked', 'Your appointment request has been recorded (demo)', 'info', 3000);
    }
  });
</script>
