@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary-emphasis">
                🛒 Riwayat Transaksi
            </h2>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill shadow-sm">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>

        @if($transactions->isEmpty())
            <div class="alert alert-info text-center">
                Belum ada transaksi.
            </div>
        @else
            <div class="row justify-content-center">
                @foreach($transactions as $transaction)
                    <div class="col-md-8 col-lg-6 mb-4">
                        <div class="card shadow-lg border-0 rounded-3">
                            <div class="card-body p-4">
                                <h5 class="card-title text-primary mb-3">Transaksi #{{ $transaction->id }}</h5>
                                
                                <h6 class="fw-semibold">Pembeli:</h6>
                                <p>{{ $transaction->buyer_name }} | {{ $transaction->email }}</p>

                                <h6 class="fw-semibold">Status:</h6>
                                <span class="badge bg-warning">{{ $transaction->status }}</span>

                                <h6 class="fw-semibold">Total Harga:</h6>
                                <p class="fs-5 fw-bold">Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                
                                <hr>

                                <h6 class="fw-semibold">Produk yang Dibeli:</h6>
                                <ul class="list-group list-group-flush">
                                    @foreach($transaction->transactionItems as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $item->product->name }}</strong><br>
                                                <small>({{ $item->quantity }} pcs)</small>
                                            </div>
                                            <span class="badge bg-secondary">Rp. {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                
                                <hr>

                                <h6 class="fw-semibold">Tanggal Transaksi:</h6>
                                <p>{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Styling untuk card dan halaman -->
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
        }

        .badge {
            font-size: 14px;
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid #f1f1f1;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .fs-5 {
            font-size: 1.25rem;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .container {
            max-width: 1200px;
        }

        .row {
            display: flex;
            justify-content: center;
        }

        .col-md-8, .col-lg-6 {
            display: flex;
            justify-content: center;
        }
    </style>
@endsection
