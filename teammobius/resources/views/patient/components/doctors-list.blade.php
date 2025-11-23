<div class="card mb-4 shadow-sm fade-in">
  <div class="card-header bg-info text-white">Available Doctors</div>
  <div class="card-body">
    <div class="row">
      @foreach($doctors as $doc)
        <div class="col-12 col-md-6 mb-3">
          <div class="p-3 border rounded h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="fw-bold">{{ $doc['name'] }}</div>
              <div class="text-muted small">{{ $doc['specialization'] }}</div>
              @if(isset($doc['experience']))<div class="mt-1"><small class="text-muted">Experience: {{ $doc['experience'] }} years</small></div>@endif
            </div>

            <div class="mt-3 d-flex gap-2">
              <button class="btn btn-primary btn-sm w-100">Book</button>
              <button class="btn btn-outline-secondary btn-sm w-100" onclick="showToast('Profile', 'Doctor profile (demo)', 'info')">Profile</button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
