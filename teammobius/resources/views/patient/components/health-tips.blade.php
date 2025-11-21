<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark fw-bold">Health Tips</div>
    <div class="card-body">
        @foreach($tips as $tip)
            <p class="mb-2">
                <i class="bi bi-heart-pulse-fill text-danger me-2"></i>
                {{ $tip }}
            </p>
        @endforeach
    </div>
</div>
