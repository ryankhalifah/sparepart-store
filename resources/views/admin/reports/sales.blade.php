@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Penjualan</li>
</ol>
@endsection

@section('content')

{{-- ===================== --}}
{{-- STYLE UNGU ELEGAN --}}
{{-- ===================== --}}

<style>
    :root {
        --purple-main: #7b48c9;
        --purple-light: #e6d6ff;
        --purple-soft: #c9a8ff;
        --purple-dark: #563094;
    }

    h3, h1, h5 {
        color: var(--purple-dark);
        font-weight: 600;
    }

    .card {
        border-radius: 14px;
        box-shadow: 0 4px 10px rgba(111, 66, 193, 0.12);
        border: none;
    }

    /* Judul Card — dibuat lembut dan tetap ungu */
    .card-header {
        background: linear-gradient(90deg, var(--purple-soft), var(--purple-light));
        color: var(--purple-dark);
        font-weight: 600;
        border-radius: 14px 14px 0 0 !important;
    }

    .card-success.card-outline {
        border-top: 3px solid var(--purple-main);
    }

    .btn-primary {
        background-color: var(--purple-main);
        border-color: var(--purple-main);
        transition: all 0.2s ease-in-out;
    }

    .btn-primary:hover {
        background-color: var(--purple-dark);
        border-color: var(--purple-dark);
    }

    .form-label {
        color: var(--purple-dark);
        font-weight: 500;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid var(--purple-soft);
    }

    .form-control:focus {
        border-color: var(--purple-main);
        box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.2);
    }

    .display-4 {
        color: var(--purple-main);
        font-weight: 700;
    }

    .text-success {
        color: var(--purple-main) !important;
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead {
        background-color: var(--purple-main);
        color: white;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(123, 72, 201, 0.08);
    }

    .breadcrumb a {
        color: var(--purple-main);
        font-weight: 500;
    }

    .breadcrumb-item.active {
        color: var(--purple-dark);
    }
</style>

{{-- ===================== --}}
{{-- Filter Tanggal --}}
{{-- ===================== --}}
<div class="mb-4 card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Periode Penjualan</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.reports.sales') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <label for="start_date" class="form-label">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ $startDate ?? '' }}">
            </div>
            <div class="col-md-5">
                <label for="end_date" class="form-label">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" class="form-control"
                    value="{{ $endDate ?? '' }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===================== --}}
{{-- Ringkasan Pendapatan --}}
{{-- ===================== --}}
<div class="mb-4 card card-success card-outline">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-chart-line"></i> Total Pendapatan Bersih (Completed)</h3>
    </div>
    <div class="text-center card-body">
        <h1 class="display-4">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h1>
        <p class="text-muted">Total dari {{ $orders->count() }} pesanan yang telah diselesaikan.</p>
    </div>
</div>

{{-- ===================== --}}
{{-- Tabel Detail Pesanan --}}
{{-- ===================== --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list"></i> Detail Pesanan Selesai</h3>
    </div>
    <div class="p-0 card-body table-responsive">
        <table class="table table-hover text-nowrap">
            <thead>
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
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td><strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle"></i> Tidak ada data penjualan dalam periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
