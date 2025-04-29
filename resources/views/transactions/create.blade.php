@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
    }
    .transaction-card {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        max-width: 800px; /* Card lebih melebar */
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        background-color: white;
    }
</style>

<div class="transaction-card">
    <div class="text-center mb-3">
        <h4 class="fw-bold text-dark">Transaksi Baru</h4>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="buyer_name" class="fw-semibold">Nama Pembeli</label>
                <input type="text" class="form-control @error('buyer_name') is-invalid @enderror"
                       id="buyer_name" name="buyer_name" required placeholder="Masukkan nama">
                @error('buyer_name')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="product_id" class="fw-semibold">Pilih Produk</label>
                <select name="product_id" id="product_id" class="form-select" required>
                    <option value="" disabled selected>Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="quantity" class="fw-semibold">Jumlah</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-semibold">Total Harga</label>
                <input type="text" id="total_price" class="form-control" readonly placeholder="Rp 0">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="amount_paid" class="fw-semibold">Uang Pembeli</label>
                <input type="number" name="amount_paid" id="amount_paid" class="form-control" min="1" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-semibold">Kembalian</label>
                <input type="text" id="change" class="form-control" readonly placeholder="Rp 0">
                <small id="error_message" class="text-danger d-none">Uang tidak mencukupi!</small>
            </div>
        </div>

        <button type="submit" id="submit_btn" class="btn btn-dark w-100 py-2 fs-6 mt-3" disabled>
            Buat Transaksi
        </button>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted small">Kembali ke Beranda</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const productSelect = document.getElementById("product_id");
        const quantityInput = document.getElementById("quantity");
        const amountPaidInput = document.getElementById("amount_paid");
        const totalPriceInput = document.getElementById("total_price");
        const changeInput = document.getElementById("change");
        const submitBtn = document.getElementById("submit_btn");
        const errorMessage = document.getElementById("error_message");

        function updateTotalPrice() {
            const selectedProduct = productSelect.options[productSelect.selectedIndex];
            const price = selectedProduct.dataset.price ? parseInt(selectedProduct.dataset.price) : 0;
            const quantity = parseInt(quantityInput.value) || 1;
            const total = price * quantity;
            
            totalPriceInput.value = total > 0 ? "Rp " + total.toLocaleString('id-ID') : "Rp 0";
            updateChange();
        }

        function updateChange() {
            const total = parseInt(totalPriceInput.value.replace(/\D/g, '')) || 0;
            const amountPaid = parseInt(amountPaidInput.value) || 0;
            const change = amountPaid - total;

            if (change < 0) {
                changeInput.value = "Rp 0";
                errorMessage.classList.remove("d-none");
                submitBtn.disabled = true;
            } else {
                changeInput.value = "Rp " + change.toLocaleString('id-ID');
                errorMessage.classList.add("d-none");
                submitBtn.disabled = false;
            }
        }

        productSelect.addEventListener("change", updateTotalPrice);
        quantityInput.addEventListener("input", updateTotalPrice);
        amountPaidInput.addEventListener("input", updateChange);
    });
</script>
@endsection