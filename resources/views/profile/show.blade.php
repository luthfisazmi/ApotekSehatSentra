@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm" style="max-width: 600px; margin: auto;">
        <div class="card-body text-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=100" class="rounded-circle mb-3" alt="Avatar">
            <h4>{{ $user->name }}</h4>
            <p class="text-muted mb-1">{{ $user->email }}</p>
            <p class="mb-0">Terdaftar sejak: {{ $user->created_at->format('d M Y') }}</p>
        </div>
    </div>
</div>
@endsection
