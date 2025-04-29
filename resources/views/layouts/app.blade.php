<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Sehat Sentra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        html, body {
            font-family: 'Poppins', sans-serif;
            background-color:rgb(255, 254, 254);
        }
        .custom-pink {
            background-color:#ffe4f5 !important;
            box-shadow: 0px 4px 6px rgba(131, 131, 131, 0.1);
        }
        .navbar-brand {
            color:rgb(52, 52, 52);
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(101, 101, 101, 0.5);
        }
        .navbar-nav .nav-link {
            color:rgb(0, 0, 0);
            font-weight: 500;
            transition: 0.3s;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
            padding-top: 20px;
        }
        footer {
            background: #ffe4f5;
            color: rgb(0, 0, 0);
            padding: 10px 0;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark custom-pink">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">Apotek Sehat Sentra</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <!-- Konten -->
        <div class="container content mt-4">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="mt-auto">
            <div class="container">
                <p class="mb-0">© 2025 Apotek Sehat Sentra | Sehat Bersama Kami</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
