@extends('layouts.app')

@section('title', 'My dashboard')

@section('content')
<h2>Welcome, {{ auth()->user()->name }} 👋</h2>
<p class="text-secondary">The pattern generator comes in the next phase.</p>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card"><div class="card-body">
            <div class="text-secondary small">My patterns</div>
            <div class="fs-2">{{ $patternsCount }}</div>
        </div></div>
    </div>
</div>
@endsection