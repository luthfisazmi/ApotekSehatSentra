<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Pastikan html dan body penuh */
        html, body {
            height: 100%;
        }

        .register-page {
            background: linear-gradient(135deg, #fff8f9, #fff);
            height: 100%; /* Menjamin bahwa halaman penuh */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }

        .register-card {
            background-color: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 500px;
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
    </style>
</head>
<body>
    <div class="register-page">
        <div class="register-card">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus-fill fs-1" style="color:#ec4899;"></i>
                <h3 class="fw-bold text-dark mt-2">Yuk Daftar Dulu~</h3>
                <p class="text-muted small">Biar bisa langsung belanja obatnya~</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') }}" required autofocus
                           placeholder="Fia Cantik Gemes">
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required
                           placeholder="contoh@gmail.com">
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required placeholder="********">
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                    <input id="password-confirm" type="password" class="form-control"
                           name="password_confirmation" required placeholder="Ulangi password">
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-pink fw-semibold py-2">Daftar</button>
                </div>
            </form>

            <p class="text-center small-link mt-3">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-pink" style="color:#ec4899;">
                    Login
                </a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
