<!-- @extends('layouts.app')

@section('content')
<h3>Checkout</h3>
<form action="{{ route('transactions.process') }}" method="POST">
    @csrf
    <input type="text" name="buyer_name" placeholder="Nama Pembeli" required>

    <h4>Produk dalam Keranjang</h4>
    <ul>
        @foreach ($cart as $id => $item)
            <li>
                {{ $item['name'] }} ({{ $item['quantity'] }}x - Rp{{ number_format($item['price']) }})
                <a href="{{ route('transactions.checkout', ['id' => $id, 'remove' => true]) }}">Hapus</a>
            </li>
        @endforeach
    </ul>
    <p>Total: Rp{{ number_format($total) }}</p>

    <label>Pilih Metode Pembayaran:</label>
    <select name="payment_method" id="payment_method" required>
        <option value="">-- Pilih --</option>
        <option value="Transfer">Transfer</option>
        <option value="E-Wallet">E-Wallet</option>
        <option value="COD">Cash on Delivery</option>
    </select>

    <div id="sub_payment_method" style="display:none;">
        <label>Detail Pembayaran:</label>
        <select name="sub_payment" id="sub_payment">
            <option value="">-- Pilih --</option>
            <option value="Bank BCA">Bank BCA</option>
            <option value="Bank Mandiri">Bank Mandiri</option>
            <option value="OVO">OVO</option>
            <option value="ShopeePay">ShopeePay</option>
        </select>
    </div>

    <div id="payment_text" style="margin-top: 10px; font-size: 14px;"></div>

    <div id="amount_paid_section" style="display: none; margin-top: 10px;">
        <label for="amount_paid">Jumlah Dibayar (Cash)</label>
        <input type="number" name="amount_paid" id="amount_paid" min="0">
    </div>

    <div id="change_display" style="display: none; margin-top: 10px;">
        <strong>Kembalian akan dihitung setelah checkout.</strong>
    </div>

    <button type="submit">Proses Checkout</button>
</form>
@endsection

@push('scripts')
<script>
    const paymentMethod = document.getElementById('payment_method');
    const subPayment = document.getElementById('sub_payment');
    const subSection = document.getElementById('sub_payment_method');
    const cashSection = document.getElementById('amount_paid_section');
    const changeDisplay = document.getElementById('change_display');
    const paymentText = document.getElementById('payment_text');

    paymentMethod.addEventListener('change', function () {
        const method = this.value;

        if (method === 'Transfer' || method === 'E-Wallet') {
            subSection.style.display = 'block';
            cashSection.style.display = 'none';
            changeDisplay.style.display = 'none';
            paymentText.innerHTML = '';
        } else if (method === 'COD') {
            subSection.style.display = 'none';
            cashSection.style.display = 'block';
            changeDisplay.style.display = 'block';
            paymentText.innerHTML = '';
        } else {
            subSection.style.display = 'none';
            cashSection.style.display = 'none';
            changeDisplay.style.display = 'none';
            paymentText.innerHTML = '';
        }
    });

    subPayment.addEventListener('change', function () {
        switch (this.value) {
            case 'Bank BCA':
                paymentText.innerHTML = "No. Rekening BCA: <strong>3890639541</strong> a/n Luthfi Azmi Sa'diyah";
                break;
            case 'Bank Mandiri':
                paymentText.innerHTML = "No. Rekening Mandiri: <strong>1234567890</strong> a/n Luthfi Azmi Sa'diyah";
                break;
            case 'ShopeePay':
                paymentText.innerHTML = "No. Shoopepay: <strong>0812-2072-9043</strong> a/n Luthfi Azmi Sa'diyah";
                break;
            case 'OVO':
                paymentText.innerHTML = "No. HP: <strong>0812-4992-8910</strong> a/n Luthfi Azmi Sa'diyah";
                break;
            default:
                paymentText.innerHTML = "";
        }
    });
</script>
@endpush -->
