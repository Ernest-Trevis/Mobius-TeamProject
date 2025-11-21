<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">Book Appointment</div>
    <div class="card-body">

        <label class="form-label fw-semibold">Choose Doctor</label>
        <select class="form-select mb-3">
            @foreach($doctors as $doc)
                <option>{{ $doc['name'] }} ({{ $doc['specialization'] }})</option>
            @endforeach
        </select>

        <label class="form-label fw-semibold">Choose Date</label>
        <input type="date" class="form-control mb-3">

        <button class="btn btn-primary w-100 shadow-sm">
            <i class="bi bi-plus-circle me-2"></i> Book Appointment
        </button>
    </div>
</div>
