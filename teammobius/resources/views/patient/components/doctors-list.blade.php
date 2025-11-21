<div class="card mb-4 shadow-sm">
    <div class="card-header bg-info text-white">Available Doctors</div>
    <div class="card-body">

        @foreach($doctors as $doc)
            <div class="p-3 border rounded mb-2">
                <h5 class="mb-1 fw-bold">{{ $doc['name'] }}</h5>
                <p class="mb-1">{{ $doc['specialization'] }}</p>
                <span class="badge bg-secondary">Experience: {{ $doc['experience'] }} yrs</span>

                <button class="btn btn-primary btn-sm mt-3 w-100">
                    <i class="bi bi-calendar-plus me-1"></i> Book with {{ $doc['name'] }}
                </button>
            </div>
        @endforeach

    </div>
</div>
