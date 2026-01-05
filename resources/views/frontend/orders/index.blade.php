@extends('layouts.admin')

@section('title', 'Daftar Pesanan Saya')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right" style="background: transparent;">
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}" style="color: #7f4acb;">Home</a>
    </li>
    <li class="breadcrumb-item active" style="color: #5e35b1;">Daftar Pesanan Saya</li>
</ol>
@endsection

@section('content')
<style>
    /* ===== Tema Ungu Elegan dengan Kontras Lebih Baik ===== */
    body {
        background-color: #f8f5fc;
        font-family: 'Poppins', sans-serif;
    }

    h4, h2 {
        color: #3c2a63; /* lebih gelap dari ungu */
        font-weight: 600;
    }

    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(123, 66, 246, 0.08);
        background: #fff;
    }

    /* HEADER GRADIENT DIBUAT LEMBUT */
    .card-header {
        background: linear-gradient(135deg, #8e63d9, #b186f6);
        border-radius: 16px 16px 0 0;
        padding: 1rem 1.25rem;
        color: #fdfdfd;
    }

    .card-header h4 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
        color: #f9f9f9; /* warna teks putih lembut agar kontras */
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(128, 0, 128, 0.05);
    }

    .table thead {
        background: #ede7f6;
        color: #4a148c;
        font-weight: 600;
    }

    .table tbody tr:hover {
        background-color: #f3e5f5;
        transition: 0.3s;
    }

    .badge {
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: capitalize;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ab47bc, #8e24aa);
        border: none;
        color: #fff;
        border-radius: 8px;
        padding: 6px 12px;
        transition: all 0.3s;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #9c27b0, #6a1b9a);
        transform: translateY(-2px);
    }

    .alert {
        border: none;
        border-radius: 10px;
        font-weight: 500;
        padding: 12px 18px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .alert-success {
        background-color: #e1bee7;
        color: #4a148c;
    }

    .alert-danger {
        background-color: #f8bbd0;
        color: #880e4f;
    }

    .pagination .page-link {
        color: #7b1fa2;
    }

    .pagination .page-item.active .page-link {
        background-color: #7b1fa2;
        border-color: #7b1fa2;
    }
</style>

<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4><i class="fas fa-shopping-bag me-2"></i> Daftar Pesanan Saya</h4>
                    <small>Total Pesanan: {{ $orders->total() }}</small>
                </div>

                <div class="card-body">
                    {{-- Notifikasi --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    {{-- Daftar Pesanan --}}
                    @if ($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover text-center align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th class="text-start">Barang</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td><strong>#{{ $order->id }}</strong></td>
                                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                            <td class="text-start">
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($order->orderItems as $item)
                                                        <li>
                                                            <strong>{{ $item->sparepart->nama ?? '—' }}</strong>
                                                            ({{ $item->jumlah }}x)
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td><strong style="color:#6a1b9a;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                                            <td>
                                                @php
                                                    $badgeClass = match ($order->status) {
                                                        'pending' => 'bg-warning',
                                                        'processing' => 'bg-info',
                                                        'shipped' => 'bg-primary',
                                                        'completed' => 'bg-success',
                                                        'cancelled' => 'bg-danger',
                                                        default => 'bg-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }} text-white">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (in_array($order->status, ['pending', 'processing']))
                                                    <form action="{{ route('frontend.myOrders.cancel', $order->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                                            <i class="fas fa-times-circle me-1"></i> Batalkan
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">Tidak bisa dibatalkan</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <div class="py-5 text-center">
                            <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                            <p class="text-muted mb-0">Belum ada pesanan yang tercatat.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
