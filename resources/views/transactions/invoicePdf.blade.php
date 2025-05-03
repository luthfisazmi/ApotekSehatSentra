<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice Transaksi #{{ $transaction->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
            width: 600px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: bold;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }

        .header-info {
            margin-bottom: 30px;
        }

        .header-info p {
            margin: 5px 0;
        }

        .header-info strong {
            color: #2980b9;
        }

        .info-left {
            width: 50%;
            float: left;
            font-size: 14px;
        }

        .info-right {
            width: 50%;
            float: right;
            font-size: 14px;
            text-align: right;
        }

        .clearfix {
            clear: both;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px 15px;
            text-align: left;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f6f9;
            color: #34495e;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .totals {
            margin-top: 30px;
            font-size: 16px;
            font-weight: 600;
            border-top: 2px solid #ecf0f1;
            padding-top: 15px;
        }

        .totals p {
            margin: 8px 0;
            font-size: 14px;
        }

        .footer {
            text-align: left;
            font-size: 12px;
            color: #95a5a6;
            margin-top: 25px;
        }

        .footer p {
            margin: 0;
        }

        .highlight {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Invoice Pembelian #{{ $transaction->id }}</h2>

    <div class="header-info">
        <div class="info-left">
            <p><strong>Pembeli:</strong> {{ $transaction->buyer_name }}</p>
            <p><strong>Email:</strong> {{ $transaction->email }}</p>
            <p><strong>Alamat:</strong> {{ $transaction->address }}</p>
        </div>

        <div class="info-right">
            <p><strong>Metode Pembayaran:</strong> {{ strtoupper($transaction->payment_method) }}</p>
            <p><strong>Tanggal:</strong> {{ date('d-m-Y', strtotime($transaction->created_at)) }}</p>
        </div>

        <div class="clearfix"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Kuantitas</th>
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

    <div class="totals">
        <p><strong>Total Harga:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
        <p><strong>Dibayar:</strong> Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</p>
        @if($transaction->payment_method == 'cod')
            <p><strong>Kembalian:</strong> <span class="highlight">Rp {{ number_format($transaction->change, 0, ',', '.') }}</span></p>
        @endif
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja dengan kami!</p>
        <p>{{ date('d-m-Y H:i', strtotime($transaction->created_at)) }}</p>
    </div>

</body>
</html>
