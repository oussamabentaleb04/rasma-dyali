@extends('layouts.app')

@section('title', 'Moderate patterns')

@section('content')
<h2 class="mb-3">All patterns</h2>

<div class="table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th>Creator</th>
                <th>Symmetry / Shape</th>
                <th>Likes</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($patterns as $pattern)
                <tr>
                    <td>
                        <canvas class="thumb" width="50" height="50" data-symmetry="{{ $pattern->symmetry_type }}" data-shape="{{ $pattern->base_shape }}" data-density="{{ $pattern->grid_density }}" data-colors="{{ json_encode($pattern->colors) }}"></canvas>
                    </td>
                    <td>{{ $pattern->title }}</td>
                    <td>{{ $pattern->user->name }}</td>
                    <td class="small text-secondary">{{ $pattern->symmetry_type }} / {{ $pattern->base_shape }}</td>
                    <td>{{ $pattern->likes_count }}</td>
                    <td>
                        @if($pattern->is_public)
                            <span class="badge bg-success">Public</span>
                        @else
                            <span class="badge bg-secondary">Private</span>
                        @endif
                        @if($pattern->is_featured)
                            <span class="badge bg-warning text-dark">Featured</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <form method="POST" action="{{ route('admin.patterns.toggleFeatured', $pattern) }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-light">{{ $pattern->is_featured ? 'Unfeature' : 'Feature' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.patterns.togglePublic', $pattern) }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-light">{{ $pattern->is_public ? 'Hide' : 'Show' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.patterns.destroy', $pattern) }}" onsubmit="return confirm('Delete this pattern?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $patterns->links('pagination::bootstrap-5') }}
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