<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Sehat Sentra</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #fffdfd;
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.4rem;
            color: #ec4899 !important;
        }

        .nav-link {
            color: #333 !important;
            font-weight: 500;
            margin-left: 1rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #ec4899 !important;
        }

        .btn-pink {
            background-color: #ec4899;
            color: white;
            border: none;
        }

        .btn-pink:hover {
            background-color: #db2777;
            color: white;
        }

        footer {
            background-color: #ffe4f5;
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
            font-size: 0.95rem;
            color: #555;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-capsule"></i> Apotek Sehat Sentra
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Home</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('transactions.index') }}">Transaksi</a>
                    </li> -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-pink ms-3 rounded-pill">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container" style="padding-top: 100px;">
        @yield('content')
    </div>

    <!-- Footer -->

<footer>
    <div class="container d-flex justify-content-center align-items-center">
        <p class="text-center w-100 mb-0">© 2025 Apotek Sehat Sentra — Sehat Bersama Kami!❤️</p>
    </div>
</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
