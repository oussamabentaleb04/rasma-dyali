@extends('layouts.app')

@section('title', 'My patterns')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">My patterns</h2>
    <a href="{{ route('generator.index') }}" class="btn btn-primary">+ New pattern</a>
</div>

<div class="row g-3">
    @forelse($patterns as $pattern)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100">
                <canvas class="thumb card-img-top" width="260" height="260" data-symmetry="{{ $pattern->symmetry_type }}" data-shape="{{ $pattern->base_shape }}" data-density="{{ $pattern->grid_density }}" data-colors="{{ json_encode($pattern->colors) }}"></canvas>
                <div class="card-body">
                    <h6>{{ $pattern->title }}</h6>
                    <p class="text-secondary small mb-2">{{ $pattern->is_public ? 'Public' : 'Private' }} · ⭐ {{ $pattern->likes_count }}</p>
                    <a href="{{ route('patterns.show', $pattern) }}" class="btn btn-sm btn-outline-primary">View</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="alert alert-secondary">No patterns yet. <a href="{{ route('generator.index') }}">Create one</a>.</div></div>
    @endforelse
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/pattern-renderer.js') }}"></script>
<script>
    document.querySelectorAll('.thumb').forEach(function (c) {
        window.RasmaRenderer.render(c, {
            symmetry: c.dataset.symmetry,
            shape: c.dataset.shape,
            density: parseInt(c.dataset.density, 10),
            colors: JSON.parse(c.dataset.colors),
        });
    });
</script>
@endpush