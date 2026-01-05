@extends('layouts.admin') {{-- Layout Admin Dashboard --}}

@section('content')
<div class="content-header mb-4">
    <h1 class="fw-bold text-purple"><i class="fas fa-chart-line me-2"></i> Laporan Penjualan 📊</h1>
</div>

<div class="content">
    {{-- Filter Tanggal --}}
    <div class="mb-4 card shadow-sm border-0">
        <div class="card-header bg-gradient-purple text-white">
            <h3 class="card-title fw-semibold"><i class="fas fa-filter me-2"></i> Filter Periode Penjualan</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.reports.sales') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="start_date" class="form-label text-purple fw-semibold">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" class="form-control form-control-purple" value="{{ $startDate }}">
                </div>

                <div class="col-md-5">
                    <label for="end_date" class="form-label text-purple fw-semibold">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" class="form-control form-control-purple" value="{{ $endDate }}">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-purple w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Ringkasan Pendapatan --}}
    <div class="mb-4 card shadow-sm border-0 elegant-card">
        <div class="card-header bg-light-purple text-dark fw-bold">
            <i class="fas fa-wallet me-2 text-purple"></i> Total Pendapatan Bersih (Completed)
        </div>
        <div class="text-center card-body">
            <h1 class="display-5 fw-bold text-purple">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h1>
            <p class="text-muted">
                Total dari {{ $orders->count() }} pesanan yang telah diselesaikan.
            </p>
        </div>
    </div>

    {{-- Tabel Detail Pesanan --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-purple text-white">
            <h3 class="card-title fw-semibold"><i class="fas fa-list-alt me-2"></i> Detail Pesanan Selesai</h3>
        </div>
        <div class="p-0 card-body table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-purple text-white">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Selesai</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="fw-semibold text-purple">#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="fw-bold text-dark">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox me-1"></i> Tidak ada data penjualan dalam periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 🌸 Tambahan CSS Tema Ungu Elegan --}}
<style>
    .bg-gradient-purple {
        background: linear-gradient(135deg, #6a1b9a, #8e24aa, #9c27b0);
    }

    .bg-light-purple {
        background-color: #f7f0fa;
    }

    .text-purple {
        color: #6a1b9a !important;
    }

    .btn-purple {
        background-color: #8e24aa;
        color: #fff;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-purple:hover {
        background-color: #6a1b9a;
        transform: scale(1.03);
    }

    .form-control-purple {
        border: 1px solid #cfa5e0;
        transition: all 0.3s ease;
    }

    .form-control-purple:focus {
        border-color: #8e24aa;
        box-shadow: 0 0 0 0.2rem rgba(142, 36, 170, 0.25);
    }

    .table-purple {
        background-color: #8e24aa;
    }

    .elegant-card {
        border-left: 6px solid #8e24aa;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        font-weight: 600;
    }

    .table-hover tbody tr:hover {
        background-color: #f4e8fa !important;
        transition: all 0.2s ease;
    }
</style>
@endsection
