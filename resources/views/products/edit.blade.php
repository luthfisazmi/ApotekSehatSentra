@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Produk</h2>
        <a href="{{ route('home') }}" class="btn btn-dark">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Produk</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            
            @if($product->image_url)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="Gambar Produk" class="img-thumbnail" style="max-height: 150px;">
                    <p class="text-muted">Gambar saat ini</p>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-outline-dark w-100 py-3 fs-5 mt-4 mb-5">Simpan</button>
    </form>
</div>
@endsection
