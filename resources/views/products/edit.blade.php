@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary-emphasis">
            ✏️ Edit Obat
        </h2>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-body p-4">
            <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Produk -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Obat</label>
                    <input type="text" name="name" class="form-control rounded-3" value="{{ $product->name }}" required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" class="form-control rounded-3" rows="3" required>{{ $product->description }}</textarea>
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control rounded-3" value="{{ $product->price }}" required>
                </div>

                <!-- Stok -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Stok</label>
                    <input type="number" name="stock" class="form-control rounded-3" value="{{ $product->stock }}" required>
                </div>

                <!-- Gambar Produk -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Gambar Produk</label>
                    <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                    
                    @if($product->image_url)
                        <div class="mt-3">
                            <p class="text-muted mb-1">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="Gambar Produk" class="img-thumbnail shadow-sm" style="max-height: 150px;">
                        </div>
                    @endif
                </div>

                <!-- Tombol Simpan -->
                <button type="submit" class="btn btn-primary w-100 py-3 fs-5 mt-4 shadow-sm rounded-pill">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
