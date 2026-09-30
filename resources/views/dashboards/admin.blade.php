@extends('layouts.app')

@section('title', 'Admin dashboard')

@section('content')
<h2>Admin dashboard 👑</h2>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card"><div class="card-body">
        <div class="text-secondary small">Users</div><div class="fs-4">{{ $usersCount }}</div>
    </div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body">
        <div class="text-secondary small">Patterns</div><div class="fs-4">{{ $patternsCount }}</div>
    </div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body">
        <div class="text-secondary small">Public patterns</div><div class="fs-4">{{ $publicPatternsCount }}</div>
    </div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body">
        <div class="text-secondary small">Featured</div><div class="fs-4">{{ $featuredCount }}</div>
    </div></div></div>
</div>

<h5>Top 5 most liked patterns</h5>
<ul class="list-group list-group-flush">
    @foreach($topPatterns as $p)
        <li class="list-group-item bg-transparent d-flex justify-content-between">
            <span><a href="{{ route('patterns.show', $p) }}">{{ $p->title }}</a></span>
            <span class="text-info">⭐ {{ $p->likes_count }}</span>
        </li>
    @endforeach
</ul>

<a href="{{ route('admin.patterns.index') }}" class="btn btn-outline-light mt-4">Manage all patterns</a>
@endsection