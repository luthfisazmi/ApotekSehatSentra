<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Apotek</title>
    
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
            display: flex;
            width: 100vw;
            max-width: 100vw;
            overflow: hidden;
            height: 100vh;
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
        .p {
            font-size: 18px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
            border-radius: 10px;
            margin: auto;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            flex-grow: 1;
        }
        .card-text.flex-grow-1 {
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
        .btn-action {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 40px;
            width: 100%;
        }
        
        .btn-edit:hover {
            background-color: yellow !important;
            color: black !important;
            border-color: black !important;
        }
        .btn-delete:hover {
            background-color: red !important;
            color: black !important;
            border-color: black !important;
        }

        .mt-auto {
            margin-top: auto;
        }

        .stok-box {
            display: inline-block;
            background-color:rgb(255, 255, 255); /* Warna latar */
            border: 1px solid #ccc; /* Garis tepi */
            border-radius: 5px; /* Sudut melengkung */
            padding: 5px 10px;
            font-size: 14px;
            font-weight: normal;
        }
        .stok-box strong {
            font-weight: bold;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-black" href="#products">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="{{ route('transactions.create') }}">Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="{{ route('transactions.index') }}">Riwayat</a>
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
        <div class="overlay"></div> <!-- Overlay Gelap -->
        <div class="container">
            <h1>Apotek Sehat Sentra</h1>
            <p class="lead">Melengkapi suplemen harian Anda!</p>
    </header>

    <!-- Produk -->
    <section id="products" class="py-5">
        <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Daftar Obat</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('products.create') }}" class="btn btn-dark px-4 py-2">+ Tambah Obat</a>
                <form action="{{ route('products.restoreAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success px-4 py-2">Restore</button>
                </form>
            </div>
        </div>

            <div class="row">
                @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                <div class="card h-100 d-flex flex-column">
                    <!-- Gambar Produk -->
                    <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : asset('images/no-image.png') }}" 
                        class="card-img-top" 
                        alt="{{ $product->name }}"> 
                    
                    <div class="card-body d-flex flex-column flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title fw-bold mb-0">{{ $product->name }}</h5>
                            <p class="card-text fw-bold mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>

                        <!-- Deskripsi Produk -->
                        <p class="card-text flex-grow-1">{{ $product->description }}</p>

                        <!-- Stok Produk -->
                        <div class="stok-box text-start mt-2 mb-3">
                            <strong>Stok:</strong> <span>{{ $product->stock }}</span>
                        </div>

                        <!-- Tombol selalu di bawah -->
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-secondary w-50 btn-edit">Edit</a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="w-50" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary w-100 btn-delete">Hapus</button>
                            </form>
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