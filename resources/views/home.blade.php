@extends('layouts.app')

@section('content')
<div class="text-center py-4">
    <h1 class="display-4 fw-bold">🎨 Rasma Dyali</h1>
    <p class="lead text-secondary">Design your own Moroccan zellige patterns, live in your browser.</p>
    <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">Get started</a>
    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Login</a>
</div>
@endsection