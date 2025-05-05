@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-5">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0 fw-bold text-danger"><i class="bi bi-heart-pulse me-2"></i> Tambah Obat 💊</h2>
                        <a href="{{ route('home') }}" class="btn btn-outline-info rounded-pill">
                            <i class="bi bi-arrow-left"></i> Kembali 
                        </a>
                    </div>

                    <form action="{{ route(name: 'products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Nama Obat</label>
                            <input type="text" name="name" class="form-control rounded-3 shadow-sm" placeholder="Contoh: Paracetamol" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="description" rows="3" class="form-control rounded-3 shadow-sm" placeholder="Deskripsi obat..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Harga Obat</label>
                            <input type="number" name="price" class="form-control rounded-3 shadow-sm" placeholder="Contoh: 10000" required onwheel="return false;" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold"> Stok Obat</label>
                            <input type="number" name="stock" class="form-control rounded-3 shadow-sm" placeholder="Contoh: 5" required onwheel="return false;" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Gambar Obat</label>
                            <input type="file" name="image" class="form-control rounded-3 shadow-sm">
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-pink btn-lg rounded-3 shadow-sm">
                                <i class="bi bi-check2-circle me-2"></i> Simpan Obat
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
