<article class="card program-card">
    <div class="program-image">
        @if(!empty($program->image))
            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
            <i class="fas {{ $program->icon ?? 'fa-graduation-cap' }}" aria-hidden="true"></i>
        @endif
    </div>
    <h2>{{ $program->title }}</h2>
    <div class="description-container">
        <p class="description-short">{{ \Illuminate\Support\Str::words($program->description, 12) }}</p>
    </div>
    @if($type === 'available')
        <a href="{{ route('user.enrollment.show', $program->id) }}" class="btn btn-primary">Enroll as student</a>
    @elseif($type === 'coming_soon')
        <button class="btn btn-secondary" disabled>Available Soon</button>
    @else
        <button class="btn btn-secondary" disabled>Registration Closed</button>
    @endif
</article>