@extends('layouts.app')

@section('title', $pattern->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <h2>{{ $pattern->title }}</h2>
        <p class="text-secondary">by {{ $pattern->user->name }}</p>

        <canvas id="canvas" width="500" height="500" class="border rounded" style="max-width: 100%; background: #f5f1e8;"></canvas>

        <div class="mt-3 d-flex gap-2 justify-content-center">
            @auth
                <form method="POST" action="{{ route('patterns.like', $pattern) }}">
                    @csrf
                    <button class="btn btn-outline-danger">
                        {{ $pattern->isLikedBy(auth()->user()) ? '❤️' : '🤍' }} {{ $pattern->likes_count }}
                    </button>
                </form>
            @else
                <span class="btn btn-outline-secondary disabled">🤍 {{ $pattern->likes_count }}</span>
            @endauth

            @if((int) $pattern->user_id === (int) auth()->id())
                <form method="POST" action="{{ route('patterns.destroy', $pattern) }}" onsubmit="return confirm('Delete this pattern?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger">Delete</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/pattern-renderer.js') }}"></script>
<script>
    window.RasmaRenderer.render(document.getElementById('canvas'), {
        symmetry: @json($pattern->symmetry_type),
        shape: @json($pattern->base_shape),
        density: @json($pattern->grid_density),
        colors: @json($pattern->colors),
    });
</script>
@endpush