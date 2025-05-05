<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Apotek Sehat Sentra</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #fff8f9, #fff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-login {
            background-color: white;
            border: none;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 480px;
        }

        .btn-pink {
            background-color: #ec4899;
            color: white;
            border: none;
        }

        .btn-pink:hover {
            background-color: #db2777;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
        }

        .form-label {
            font-weight: 500;
        }

        .small-link {
            font-size: 0.9rem;
        }

        /* Adding custom styling for header with icon */
        .header-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .header-logo i {
            font-size: 2rem;
            color: #ec4899;
        }
    </style>
</head>
<body>

<div class="card-login">
        <div class="text-center mb-4 header-logo">
            <i class="bi bi-heart-pulse"></i>
            <h3 class="fw-bold text-dark mt-2">Apotek Sehat Sentra</h3>
        </div>

        <p class="text-muted text-center mt-4">Selamat datang!</p>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-pink fw-semibold py-2">Login</button>
        </div>
    </form>

    <p class="text-center small-link mt-3">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-pink" style="color:#ec4899;">
            Daftar
        </a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
