@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold text-primary-emphasis">
                🛒 Riwayat Transaksi
            </h2>
            <div class="d-flex">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill shadow-sm me-2">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>

                <!-- Tombol Restore All (Untuk memulihkan semua transaksi yang dihapus) -->
                <form action="{{ route('transactions.restoreAll') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning rounded-pill">
                        <i class="bi bi-arrow-counterclockwise"></i> Restore All
                    </button>
                </form>
            </div>
        </div>

        <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
            <table class="table table-hover align-middle text-center table-bordered">
                <thead class="table-primary text-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Pembeli</th>
                        <th>Email</th>
                        <th>Produk</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>#{{ $transaction->id }}</td>
                        <td>{{ $transaction->buyer_name }}</td>
                        <td>{{ $transaction->email }}</td>
                        <td class="text-start">
                            <ul class="list-unstyled mb-0">
                                @foreach($transaction->transactionItems as $item)
                                    <li>
                                        {{ $item->product->name }} <small>({{ $item->quantity }} pcs)</small>
                                        - Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="fw-bold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge 
                                @if($transaction->status == 'Selesai') bg-success 
                                @elseif($transaction->status == 'Menunggu Konfirmasi') bg-warning 
                                @else bg-secondary @endif">
                                {{ $transaction->status }}
                            </span>
                        </td>
                        <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            @if($transaction->trashed())
                                <!-- Tombol Restore -->
                                <form action="{{ route('transactions.restore', $transaction->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill">
                                        <i class="bi bi-arrow-counterclockwise"></i> Restore
                                    </button>
                                </form>
                            @else
                                <!-- Tombol Hapus -->
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <style>
        .container { flex: 1; }
        .footer { margin-top: auto; }
        table th, table td { vertical-align: middle; }
        ul { padding-left: 1rem; }
        ul li { font-size: 0.95rem; }
        .table thead th { font-weight: 600; }
        .badge { font-size: 14px; }
        .fw-bold { font-weight: 700; }
    </style>
@endsection
