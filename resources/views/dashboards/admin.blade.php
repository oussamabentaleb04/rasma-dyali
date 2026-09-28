@extends('layouts.app')

@section('title', 'Admin dashboard')

@section('content')
<h2>Admin dashboard 👑</h2>
<div class="row g-3">
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
@endsection