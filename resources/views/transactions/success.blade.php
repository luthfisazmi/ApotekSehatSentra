<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Berhasil</title>

    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Basic CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 40px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        h1, h2 {
            color: #c0335e;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            font-family: 'Poppins', sans-serif;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        th {
            background-color: #f1f1f1;
            font-weight: 600;
            text-align: center;
        }

        td:nth-child(2),
        td:nth-child(3),
        td:nth-child(4) {
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin: 10px 8px;
            transition: all 0.3s ease;
            font-size: 16px;
            border: 2px solid transparent;
        }

        .btn-outline-red {
            color: #dc3545;
            border-color: #dc3545;
            background-color: transparent;
        }

        .btn-outline-red:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-outline-blue {
            color: #007bff;
            border-color: #007bff;
            background-color: transparent;
        }

        .btn-outline-blue:hover {
            background-color: #007bff;
            color: #fff;
        }

        .text-center {
            text-align: center;
        }

        ul.list-group {
            list-style: none;
            padding-left: 0;
        }

        ul.list-group li {
            padding: 10px 0;
            border-bottom: 1px solid #e5e5e5;
        }

        ul.list-group li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Transaksi Berhasil! 🎉</h1>
        <p class="text-center mb-2">Selamat, <strong>{{ $transaction->buyer_name }}</strong>!</p>

        <h2 class="mt-4 mb-3" style="font-weight: 600;">🧾 Detail Transaksi</h2>

        <ul class="list-group mb-4" style="font-size: 16px;">
            <li><strong>ID Transaksi:</strong> {{ $transaction->id }}</li>
            <li><strong>Email:</strong> {{ $transaction->email }}</li>
            <li><strong>Alamat:</strong> {{ $transaction->address }}</li>
            <li><strong>Metode Pembayaran:</strong>
                {{ strtoupper($transaction->payment_method) == 'COD' ? 'Cash on Delivery (COD)' : 'Transfer Bank' }}
            </li>

            @if($transaction->payment_method === 'transfer')
                <li><strong>Bank:</strong> {{ strtoupper($transaction->sub_payment) }}</li>
            @endif

            <li><strong>Total Harga:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</li>

            @if($transaction->payment_method === 'cod')
                <li><strong>Bayar:</strong> Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</li>
                <li><strong>Kembalian:</strong> Rp {{ number_format($transaction->change, 0, ',', '.') }}</li>
            @endif
        </ul>

        <h2 class="mt-4 mb-3" style="font-weight: 600;">🛒 Daftar Produk</h2>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total</th>
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

        <div class="text-center">
            <a href="{{ route('transactions.invoicePdf', ['transactionId' => $transaction->id]) }}" class="btn btn-outline-red" target="_blank">🧾 Download Invoice (PDF)</a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-blue">🔙 Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
