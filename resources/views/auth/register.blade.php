@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa; /* Warna abu-abu soft */
    }
    .register-card {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        max-width: 600px; /* Ukuran card tetap nyaman */
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        background-color: white;
    }
</style>

<div class="register-card">
    <div class="text-center mb-3">
        <h3 class="fw-bold text-dark">Daftar Akun</h3>
        <p class="text-muted">Silakan daftar untuk melanjutkan</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="fw-semibold">Nama Lengkap</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                   name="name" value="{{ old('name') }}" required autofocus
                   placeholder="Masukkan nama lengkap">
            @error('name')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="fw-semibold">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required
                   placeholder="Masukkan email anda">
            @error('email')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="fw-semibold">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                   name="password" required placeholder="Masukkan password">
            @error('password')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password-confirm" class="fw-semibold">Konfirmasi Password</label>
            <input id="password-confirm" type="password" class="form-control"
                   name="password_confirmation" required
                   placeholder="Masukkan kembali password">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-dark w-100 fw-semibold py-2">
                Daftar
            </button>
        </div>
    </form>

    <p class="text-center small">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Login di sini</a>
    </p>
</div>
@endsection
