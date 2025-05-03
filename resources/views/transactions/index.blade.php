@extends('layouts.app')

@section('content')

<style>
    .btn-outline-pink {
    color: #d63384;
    border: 1px solid #d63384;
    background-color: transparent;
    box-shadow: 0 4px 12px rgba(166, 166, 166, 0.15);
    transition: 0.2s ease;
}

.btn-outline-pink:hover {
    background-color: #d63384;
    color: #fff;
}
</style>



<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="mb-4 text-center fw-bold">🛒 Checkout Keranjang</h2>
                    <div class="d-flex justify-content-end mb-4">
                        <a href="{{ route('cart.cancel') }}" class="btn btn-outline-pink">
                            <i class="bi bi-x-circle"></i> Hapus Keranjang
                        </a>
                    </div>


                    {{-- Alert --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('transactions.processCheckout') }}">
                        @csrf

                        {{-- Tabel Produk dalam Keranjang --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Produk dalam Keranjang:</label>
                            <table class="table table-bordered text-center align-middle">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Kuantitas</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach ($cartItems as $item)
                                        @php
                                            $subtotal = $item->product->price * $item->quantity;
                                            $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    <span id="qty-{{ $item->product->id }}">{{ $item->quantity }}</span>
                                                </div>
                                            </td>
                                            <td id="subtotal-{{ $item->product->id }}">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <!-- <button type="button" class="btn btn-sm btn-primary mb-1" onclick="tambahKuantitas({{ $item->product->id }})">Tambah</button> -->
                                                <form action="{{ route('transactions.removeFromCart', $item->product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td colspan="2" class="fw-bold" id="total-harga">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Tambah Produk --}}
                        <div class="mb-4">
                            <label for="add_product" class="form-label fw-semibold">Tambah Produk</label>
                            <select id="add_product" class="form-select" onchange="addToCart(this.value)">
                                <option value="">-- Pilih Produk --</option>
                                @foreach (App\Models\Product::all() as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} - Rp{{ number_format($product->price) }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Data Pembeli --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Alamat</label>
                            <textarea name="address" id="address" rows="3" class="form-control" required></textarea>
                        </div>

                        {{-- Metode Pembayaran --}}
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
                                <option value="BCA">BCA - No. Rek 12345678910 a.n. Luthfi Azmi Sadiyah</option>
                                <option value="BNI">BNI - No. Rek 12345678910 a.n. Luthfi Azmi Sadiyah</option>
                                <option value="Mandiri">Mandiri - No. Rek 12345678910 a.n. Luthfi Azmi Sadiyah</option>
                                <option value="OVO">OVO - No. Telp 08122012345 a.n. Luthfi Azmi Sadiyah</option>
                            </select>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-bag-check"></i> Selesai Checkout
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
    function tambahKuantitas(productId) {
        fetch("{{ route('transactions.updateCart') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                id: productId,
                action: 'increase'
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`qty-${productId}`).textContent = data.updatedQuantity;
                document.getElementById(`subtotal-${productId}`).textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(data.updatedSubtotal);
                document.getElementById('total-harga').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(data.total);
            }
        });
    }

    function toggleBankInfo(method) {
        document.getElementById('bank-options').style.display = (method === 'transfer') ? 'block' : 'none';
    }

    function addToCart(productId) {
        if (!productId) return;
        window.location.href = `/add-to-cart/${productId}`;
    }
</script>
@endsection
