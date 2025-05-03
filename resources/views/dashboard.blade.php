<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Sehat Sentra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        .navbar-brand {
            color: black !important;
            text-shadow: 2px 2px 4px rgba(123, 123, 123, 0.5);
        }
        .navbar-brand:hover {
            color: gray !important;
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgb(255, 255, 255);
        }
        .navbar .nav-link {
            color: black !important;
            transition: background-color 0.3s ease;
            text-shadow: 2px 2px 4px rgba(123, 123, 123, 0.5);
        }
        .navbar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: rgb(226, 103, 138) !important;
        }

        .btn-pink {
            background-color: #c0335e; 
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 16px 18px; 
            border-radius: 999px; 
            width: 200px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); 
            transition: background-color 0.3s ease;
            border: none;
        }

        .btn-pink:hover {
        background-color: #ff889c; 
        }

        .btn-pink:active {
        background-color: rgb(226, 103, 138) !important; /* Klik lebih gelap lagi */
        }

        header {
            position: relative;
            background-image: url("{{ asset('storage/apotiksehat3.jpg') }}");
            background-position: center 2px;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 400px;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: left;
            color: white;
            padding: 0;
            margin-top: 0;
        }

        header .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        header .content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            padding-left: 50px;
        }

        header h1 {
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(158, 158, 158, 0.7);
        }

        .lead {
            font-family: 'Poppins', sans-serif;
            font-weight: 400; /* atau 600 kalau mau lebih tebal */
            font-size: 1.2rem; /* bisa kamu sesuaikan */
            color:rgb(45, 45, 45); /* ganti dengan warna yang diinginkan */
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-grow: 1;
        }
        .card:hover {
            transform: scale(1.05);
            background-color: rgba(255, 255, 255, 0.05);
        }
        .card-img-top {
            height: 200px;
            object-fit: contain;
        }

        .btn-container {
            display: flex;
            gap: 10px;
        }

        .btn-view {
            border: 1px solid #007bff;
            color: #007bff;
            background-color: white;
        }

        .btn-view:hover {
            background-color: #007bff;
            color: white;
        }

        .btn-buy {
            background-color: white;
            color: #dc3545;
            border: 1px solid #dc3545;
            transition: 0.3s;
        }

        .btn-buy:hover {
            background-color: #dc3545;
            color: white;
        }

        .mt-auto {
            margin-top: auto;
        }

        footer {
            display: flex;
            text-align: center;
            align-items: center;
            justify-content: center;
            background-color:rgb(255, 226, 231);
            text-shadow: 2px 2px 4px rgba(172, 172, 172, 0.5);
            color: #c0335e;
            padding: 10px 0;
            height: 50px;
        }

        footer p {
            margin: 0;
            width: 100%;
            text-align: center;
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Apotek Sehat Sentra</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-black" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="#products">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="{{ route('transactions.index') }}">Checkout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="#">FAQ</a>
                    </li>
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-black" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="Avatar" width="30" height="30" class="rounded-circle me-2">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Lihat Profil</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="text-black py-5">
        <div class="overlay"></div>
        <div class="container">
            <h1>Apotek Sehat Sentra</h1>
            <p class="lead">Lengkapi Suplemen Harian Anda untuk Kesehatan yang Optimal!</p>
            <a href="#products" class="btn btn-pink">Lihat Produk</a>
        </div>
    </header>

    <!-- Produk -->
    <section id="products" class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Daftar Obat</h2>
            </div>

            <form method="GET" action="{{ route('dashboard') }}#products" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari obat..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>

            <div class="row">
                @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : asset('images/no-image.png') }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title fw-bold mb-0">{{ $product->name }}</h5>
                                <p class="fw-bold mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="card-text">{{ Str::limit($product->description, 60) }}</p>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between gap-2">
                                    <!-- Button View trigger modal -->
                                    <button type="button" class="btn btn-outline-primary btn-view w-50" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                        View
                                    </button>

                                    <!-- Button Beli -->

                                    <a href="{{ route('transactions.checkoutNow', $product->id) }}" class="btn btn-buy w-50">Checkout</a>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk setiap produk -->
                <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel{{ $product->id }}">{{ $product->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : asset('images/no-image.png') }}" class="img-fluid mb-3" alt="{{ $product->name }}">
                        <p><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p><strong>Deskripsi:</strong> {{ $product->description }}</p>
                        <p><strong>Stok:</strong> <span>{{ $product->stock }}</span></p>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach

                @if($products->isEmpty())
                    <p class="text-center">Tidak ada produk tersedia.</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <p>&copy; 2025 Apotek Sehat Sentra — Sehat Bersama Kami!❤️</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
