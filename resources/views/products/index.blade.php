@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Produk</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    @if($product->image_url)
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="Gambar Produk" class="img-thumbnail" style="max-height: 100px;">
                    @else
                        <span>Tidak ada gambar</span>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                        </form>
                        <form action="{{ route('products.restoreAll') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Restore</button>
                        </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
