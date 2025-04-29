@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Tambah Obat</h2>
            <a href="{{ route('home') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
    </div>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Nama Obat -->
        <div class="mb-3">
            <label class="form-label">Nama Obat</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <!-- Harga -->
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <!-- Stok -->
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <!-- Gambar Produk -->
        <div class="mb-3">
            <label class="form-label">Gambar Produk</label>
            <input type="file" name="image" class="form-control">
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-outline-dark w-100 py-3 fs-5 mt-4 mb-5">Simpan</button>
    </form>
</div>
@endsection
