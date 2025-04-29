<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi</title>

    {{-- CDN Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card shadow-lg border-0 rounded-4 px-4 py-3">
        <div class="card-header text-center bg-white border-0">
            <h3 class="fw-bold text-dark">Selamat Datang</h3>
            <p class="text-muted">Silakan masuk untuk melanjutkan</p>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="fw-semibold">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autofocus
                           placeholder="Masukkan email anda"
                           style="border-radius: 10px; padding: 12px; font-size: 16px;">

                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="fw-semibold">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required placeholder="Masukkan password"
                           style="border-radius: 10px; padding: 12px; font-size: 16px;">

                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-dark w-100 fw-semibold py-2" style="border-radius: 10px;">
                        Login
                    </button>
                </div>
            </form>

            <p class="text-center small">
                Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Daftar</a>
            </p>
        </div>
    </div>
</div>

{{-- Optional JS Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
