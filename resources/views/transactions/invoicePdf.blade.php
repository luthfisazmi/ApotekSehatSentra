<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $transaction->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            color: #2c3e50;
            background-color: #fff;
            margin: 0 auto;
            padding: 30px;
            max-width: 700px;
        }

        h1 {
            text-align: center;
            font-size: 26px;
            color: #c0335e; /* #c0335e untuk header */
            margin-bottom: 10px;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }

        h3 {
            text-align: center;
            font-size: 18px;
            color: #7f8c8d; /* warna lebih ringan untuk nama apotek */
            margin-top: 5px;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-box p {
            margin: 4px 0;
            line-height: 1.4;
        }

        .info-box strong {
            color: #34495e;
        }

        .info-box p span {
            color: #c0335e; /* #c0335e untuk teks info tertentu */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #ecf6fc;
        }

        th, td {
            padding: 10px;
            border: 1px solid #dce1e5;
            text-align: left;
        }

        th {
            color: #2c3e50;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .summary {
            margin-top: 20px;
            border-top: 2px solid #bdc3c7;
            padding-top: 15px;
            font-size: 15px;
        }

        .summary p {
            margin: 6px 0;
        }

        .summary strong {
            color: #c0335e; /* #c0335e untuk teks summary */
        }

        .highlight {
            font-weight: bold;
            color: #e74c3c;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>

    <h1>INVOICE PEMBELIAN</h1>
    <h3>Apotek Sehat Sentra</h3> <!-- Nama Apotek ditambahkan di sini -->

    <div class="info-section">
        <div class="info-box">
            <p><strong>Nomor Transaksi:</strong> #{{ $transaction->id }}</p>
            <p><strong>Tanggal:</strong> <span>{{ date('d-m-Y H:i', strtotime($transaction->created_at)) }}</span></p>
        </div>
        <div class="info-box">
            <p><strong>Nama Pembeli:</strong> {{ $transaction->buyer_name }}</p>
            <p><strong>Email:</strong> {{ $transaction->email }}</p>
            <p><strong>Alamat:</strong> {{ $transaction->address }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->transactionItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Total:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
        <p><strong>Metode Pembayaran:</strong> 
            <span style="color: #c0335e;">{{ strtoupper($transaction->payment_method === 'cod' ? 'Cash (COD)' : 'Transfer - ' . strtoupper($transaction->sub_payment)) }}</span>
        </p>
        <p><strong>Dibayar:</strong> Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</p>

        @if($transaction->payment_method === 'cod')
            <p><strong>Kembalian:</strong> <span class="highlight">Rp {{ number_format($transaction->change, 0, ',', '.') }}</span></p>
        @endif
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja di Apotek Sehat Sentra - Sehat Bersama Kami!</p>
        <p>Dicetak pada {{ date('d-m-Y H:i') }}</p>
    </div>

</body>
</html>
