<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Sehat Sentra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        .navbar-brand {
            color: black !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
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
            text-shadow: 2px 2px 4px rgba(70, 70, 70, 0.5);
        }
        .navbar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: rgb(226, 103, 138) !important;
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
        }
        header .content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            padding-left: 50px;
        }
        header h1 {
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(52, 52, 52, 0.7);
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
            background-color: rgb(226, 103, 138);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            color: white;
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
                        <a class="nav-link text-black" href="#dashboard">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="#products">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black" href="{{ route('login') }}">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="text-black py-5">
        <div class="overlay"></div>
        <div class="container">
            <h1>Apotek Sehat Sentra</h1>
            <p class="lead">Melengkapi Suplemen Harian Anda!</p>
        </div>
    </header>

    <!-- Produk -->
    <section id="products" class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Daftar Obat</h2>
            </div>

            <div class="row">
                @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : asset('images/no-image.png') }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">{{ $product->name }}</h5>
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
                                    <form action="{{ route('transactions.store') }}" method="POST" class="w-50">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-buy w-100">
                                            Beli Obat
                                        </button>
                                    </form>
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
        <p>&copy; 2025 Apotek Sehat. Semua Hak Dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
