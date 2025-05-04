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
                    
                    <!-- Hapus Keranjang -->
                    <div class="d-flex justify-content-end mb-4">
                        <a href="{{ route('cart.cancel') }}" class="btn btn-outline-pink">
                            <i class="bi bi-x-circle"></i> Hapus Keranjang
                        </a>
                    </div>

                    <!-- Alert -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Tabel Produk dalam Keranjang -->
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

                    <!-- Tambah Produk -->
                    <div class="mb-4">
                        <label for="add_product" class="form-label fw-semibold">Tambah Produk</label>
                        <select id="add_product" class="form-select" onchange="addToCart(this.value)">
                            <option value="">-- Pilih Produk --</option>
                            @foreach (App\Models\Product::all() as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} - Rp{{ number_format($product->price) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Form Checkout -->
                    <form method="POST" action="{{ route('transactions.processCheckout') }}">
                        @csrf

                        <!-- Data Pembeli -->
                        <label for="buyer_name" class="form-label fw-semibold">Nama</label>
                        <input type="text" class="form-control" id="buyer_name" name="buyer_name" required>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Alamat</label>
                            <textarea name="address" id="address" rows="3" class="form-control" required></textarea>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mb-3 mt-4">
                            <label for="payment_method" class="form-label fw-semibold">Metode Pembayaran</label>
                            <select name="payment_method" class="form-select" required onchange="togglePaymentDetails(this.value)">
                                <option value="">-- Pilih --</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="cod">Cash on Delivery (COD)</option>
                            </select>
                        </div>

                        <!-- Untuk Transfer Bank -->
                        <div id="bank-options" class="mb-3" style="display: none;">
                            <label for="sub_payment" class="form-label fw-semibold">Pilih Bank</label>
                            <select name="sub_payment" id="sub_payment" class="form-select">
                                <option value="BCA">BCA - No. Rek 12345678910 a.n. Luthfi Azmi Sadiyah</option>
                                <option value="BNI">BNI - No. Rek 12345678910 a.n. Luthfi Azmi Sadiyah</option>
                                <option value="Mandiri">Mandiri - No. Rek 12345678910 a.n. Luthfi Azmi Sadiyah</option>
                                <option value="OVO">OVO - No. Telp 08122012345 a.n. Luthfi Azmi Sadiyah</option>
                            </select>
                        </div>

                        <!-- Untuk COD -->
                        <div id="cod-options" class="mb-3" style="display: none;">
                            <label for="amount_paid" class="form-label fw-semibold">Jumlah Uang yang Dibayar</label>
                            <input type="number" name="amount_paid" id="amount_paid" class="form-control" min="0" placeholder="Masukkan jumlah uang yang dibayar" required>
                            <small class="text-muted">Masukkan jumlah uang yang dibayar. Kembalian akan dihitung otomatis.</small>

                            <div id="change-display" class="mt-3" style="display: none;">
                                <label for="change_amount" class="form-label fw-semibold">Kembalian</label>
                                <input type="text" id="change_amount" class="form-control" readonly>
                            </div>
                        </div>

                        <!-- Form Checkout Submit -->
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
document.addEventListener('DOMContentLoaded', function () {
    // Tambah kuantitas produk di cart
    window.tambahKuantitas = function(productId) {
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

    // Toggle metode pembayaran
    window.togglePaymentDetails = function(paymentMethod) {
        const bankOptions = document.getElementById('bank-options');
        const codOptions = document.getElementById('cod-options');
        const subPayment = document.getElementById('sub_payment');
        const amountPaid = document.getElementById('amount_paid');

        if (paymentMethod === 'transfer') {
            bankOptions.style.display = 'block';
            codOptions.style.display = 'none';
            subPayment.disabled = false;
            amountPaid.disabled = true;
            amountPaid.value = '';
            document.getElementById('change-display').style.display = 'none';
        } else if (paymentMethod === 'cod') {
            codOptions.style.display = 'block';
            bankOptions.style.display = 'none';
            subPayment.disabled = true;
            subPayment.value = '';
            amountPaid.disabled = false;
        } else {
            bankOptions.style.display = 'none';
            codOptions.style.display = 'none';
            subPayment.disabled = true;
            amountPaid.disabled = true;
            amountPaid.value = '';
            document.getElementById('change-display').style.display = 'none';
        }
    }

    // Kalkulasi kembalian
    const amountPaidInput = document.getElementById('amount_paid');
    if (amountPaidInput) {
        amountPaidInput.addEventListener('input', function () {
            const totalText = document.getElementById('total-harga').textContent.replace(/[^\d]/g, '');
            const totalPrice = parseFloat(totalText) || 0;
            const amountPaid = parseFloat(this.value) || 0;
            const change = amountPaid - totalPrice;

            const changeInput = document.getElementById('change_amount');
            if (changeInput) {
                changeInput.value = change >= 0 ? change.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) : '';
            }

            document.getElementById('change-display').style.display = change >= 0 ? 'block' : 'none';
        });
    }

    // Tambah ke keranjang
    window.addToCart = function(productId) {
        if (!productId) return;
        window.location.href = `/add-to-cart/${productId}`;
    }
});
</script>


@endsection
