@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pesanan</li>
</ol>
@endsection

@section('content')

{{-- 🌸 TEMA UNGU ELEGAN MODERN --}}
<style>
    :root {
        --purple-main: #6f42c1;
        --purple-light: #d8c7ff;
        --purple-dark: #4b2a91;
        --purple-bg: #f6f3fa;
    }

    body {
        background-color: var(--purple-bg);
        font-family: "Poppins", sans-serif;
        color: #3b2c59;
    }

    /* Card */
    .card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 6px 18px rgba(111, 66, 193, 0.15);
        background-color: #fff;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(111, 66, 193, 0.2);
    }

    /* Header Card */
    .card-header {
        background: linear-gradient(135deg, var(--purple-main), var(--purple-dark));
        color: #fff;
        border-radius: 18px 18px 0 0;
        padding: 1.2rem 1.5rem;
    }

    .card-title {
        font-weight: 600;
        font-size: 1.3rem;
        letter-spacing: 0.4px;
    }

    /* Table */
    .table {
        border-radius: 12px;
        overflow: hidden;
        background-color: #fff;
    }

    .table thead th {
        background-color: #ede7f6;
        font-weight: 600;
        text-transform: uppercase;
        color: #4b3c7d;
        border-bottom: 2px solid #d6c9f3;
        font-size: 0.9rem;
    }

    .table tbody tr {
        transition: all 0.2s ease-in-out;
    }

    .table tbody tr:hover {
        background-color: #f8f4ff;
    }

    .table td {
        vertical-align: middle;
        color: #3b2c59;
        font-size: 0.95rem;
    }

    /* Alerts */
    .alert-success {
        border-left: 6px solid #8e44ad;
        border-radius: 10px;
        background: #f3e9fc;
        color: #45245e;
        font-weight: 500;
    }

    .alert-danger {
        border-left: 6px solid #c0392b;
        border-radius: 10px;
        background: #fdeaea;
        color: #6d1b1b;
        font-weight: 500;
    }

    /* Buttons */
    .btn-primary {
        background-color: var(--purple-main);
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: 0.3s ease;
        box-shadow: 0 2px 6px rgba(111, 66, 193, 0.25);
    }

    .btn-primary:hover {
        background-color: var(--purple-dark);
        box-shadow: 0 0 12px rgba(111, 66, 193, 0.4);
    }

    .btn-info {
        background: linear-gradient(135deg, #9b59b6, #6f42c1);
        border: none;
        border-radius: 8px;
        transition: 0.3s ease;
        color: #fff;
        box-shadow: 0 2px 6px rgba(139, 92, 246, 0.3);
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #8240b5, #5e36a2);
        box-shadow: 0 0 10px rgba(139, 92, 246, 0.5);
    }

    /* Badges */
    .badge {
        padding: 6px 10px;
        font-size: 0.85rem;
        border-radius: 8px;
        text-transform: capitalize;
        font-weight: 500;
    }

    .badge.bg-success {
        background-color: #7b3fb9 !important;
    }

    .badge.bg-primary {
        background-color: #7456df !important;
    }

    .badge.bg-warning {
        background-color: #d8a100 !important;
        color: #fff;
    }

    .badge.bg-danger {
        background-color: #e74c3c !important;
    }

    .badge.bg-info {
        background-color: #9b59b6 !important;
    }

    /* Dropdown Status */
    select.form-control-sm {
        border-radius: 6px;
        border: 1px solid #cbb8f3;
        background-color: #faf7ff;
        color: #3b2c59;
        font-size: 0.9rem;
    }

    select.form-control-sm:focus {
        border-color: var(--purple-main);
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.2);
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 1rem;
    }

    .page-link {
        border: none;
        border-radius: 8px;
        color: var(--purple-main);
        font-weight: 500;
        transition: 0.3s;
    }

    .page-link:hover {
        background-color: #f3e9fc;
        color: var(--purple-dark);
    }

    .page-item.active .page-link {
        background-color: var(--purple-main);
        color: #fff;
        border: none;
        box-shadow: 0 0 8px rgba(111, 66, 193, 0.4);
    }

    /* Layout spacing */
    .content-wrapper {
        background-color: var(--purple-bg);
        padding: 2rem;
    }

    /* Animasi Halus */
    .card, .table, .btn, select, .alert {
        transition: all 0.3s ease-in-out;
    }

    h3, th {
        letter-spacing: 0.3px;
    }

    /* Empty table */
    .text-center {
        color: #7d6ca8;
    }
</style>

{{-- ✅ NOTIFIKASI --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- ✅ KONTEN CARD PESANAN --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-box-open mr-2"></i> Daftar Pesanan Masuk</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Pesan</th>
                        <th>Nama Barang</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th style="width: 20%;">Ubah Status</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'User Dihapus' }}</td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                @foreach ($order->orderItems as $item)
                                    <div>
                                        {{ $item->sparepart->nama ?? 'Spare Part Dihapus' }} (x{{ $item->jumlah }})
                                    </div>
                                @endforeach
                            </td>
                            <td><strong>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-warning',
                                        'processing' => 'bg-info',
                                        'shipped' => 'bg-primary',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger'
                                    ];
                                @endphp
                                <span class="badge {{ $statusColors[$order->status] ?? 'bg-secondary' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                    data-target="#detailModal-{{ $order->id }}">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINASI --}}
        <div class="mt-3">
            {{ $orders->links() }}
        </div>

        {{-- MODAL DETAIL --}}
        @foreach ($orders as $order)
            @include('admin.orders.modal_detail', ['order' => $order])
        @endforeach
    </div>
</div>

@endsection
