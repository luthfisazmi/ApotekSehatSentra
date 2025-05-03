<!-- @extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="mb-4 text-center fw-bold">🛒 Checkout Keranjang</h2>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('transactions.processCheckout') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="buyer_name" class="form-label fw-semibold">Nama Pembeli</label>
                            <input type="text" name="buyer_name" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label for="buyer_email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="buyer_email" class="form-control" placeholder="email@domain.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="buyer_address" class="form-label fw-semibold">Alamat</label>
                            <textarea name="buyer_address" class="form-control" rows="3" placeholder="Tulis alamat lengkap pengiriman..." required></textarea>
                        </div>

                        <h5 class="mb-3 fw-bold">🧾 Daftar Produk</h5>
                        @forelse ($cart as $id => $item)
                            <div class="card mb-2 shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item['name'] }}</strong><br>
                                        Harga: Rp{{ number_format($item['price']) }} x {{ $item['quantity'] }}
                                    </div>
                                    <a href="{{ route('transactions.checkout', ['id' => $id, 'remove' => 1]) }}" class="btn btn-outline-danger btn-sm">Hapus</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted fst-italic">Keranjang masih kosong.</p>
                        @endforelse

                        <div class="mb-3 mt-4">
                            <label for="add_product" class="form-label fw-semibold">Tambah Produk</label>
                            <select id="add_product" class="form-select" onchange="addToCart(this.value)">
                                <option value="">-- Pilih Produk --</option>
                                @foreach (App\Models\Product::all() as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} - Rp{{ number_format($product->price) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <h5 class="mt-4">Total Harga: <strong class="text-success">Rp{{ number_format($total) }}</strong></h5>

                        <div class="mb-3 mt-4">
                            <label for="payment_method" class="form-label fw-semibold">Metode Pembayaran</label>
                            <select name="payment_method" class="form-select" required onchange="toggleBankInfo(this.value)">
                                <option value="">-- Pilih --</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="cod">Cash on Delivery (COD)</option>
                            </select>
                        </div>

                        <div id="bank-options" class="mb-3" style="display: none;">
                            <label for="sub_payment" class="form-label fw-semibold">Pilih Bank</label>
                            <select name="sub_payment" class="form-select">
                                <option value="BCA">BCA - No. Rek 12345678910 a.n. Luthfi Azmi</option>
                                <option value="Mandiri">Mandiri - No. Rek 12345678910 a.n. Luthfi Azmi</option>
                                <option value="BNI">BNI - No. Rek 12345678910 a.n. Luthfi Azmi</option>
                                <option value="OVO">OVO - No. Rek 12345678910 a.n. Luthfi Azmi</option>
                            </select>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-bag-check"></i> Selesai Checkout
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap JS interactivity --}}
<script>
    function toggleBankInfo(method) {
        document.getElementById('bank-options').style.display = (method === 'transfer') ? 'block' : 'none';
    }

    function addToCart(productId) {
        if (!productId) return;
        window.location.href = `/add-to-cart/${productId}`;
    }
</script>
@endsection -->
