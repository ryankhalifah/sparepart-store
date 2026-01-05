@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
</ol>
@endsection

@section('content')

{{-- ===================== --}}
{{-- STYLE DASHBOARD UNGU ELEGAN --}}
{{-- ===================== --}}
<style>
    :root {
        --purple-main: #6f42c1;
        --purple-light: #d9c3ff;
        --purple-dark: #4b2a91;
        --bg-light: #f8f5ff;
    }

    body {
        background-color: var(--bg-light);
        font-family: 'Poppins', sans-serif;
    }

    h5 {
        color: var(--purple-dark);
        font-weight: 600;
        border-left: 5px solid var(--purple-main);
        padding-left: 10px;
        margin-bottom: 1rem;
        letter-spacing: 0.5px;
    }

    /* Card Info Box */
    .info-box {
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(111, 66, 193, 0.15);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .info-box:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 18px rgba(111, 66, 193, 0.25);
    }

    .info-box-icon {
        border-radius: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        background: linear-gradient(145deg, var(--purple-main), var(--purple-dark));
        color: #fff !important;
    }

    .info-box-content {
        padding: 12px 15px;
    }

    .info-box-text {
        color: #5a2b97;
        font-weight: 500;
    }

    .info-box-number {
        color: var(--purple-dark);
        font-size: 1.5rem;
        font-weight: 700;
    }

    /* Small Box (Sparepart Section) */
    .small-box {
        background: linear-gradient(135deg, var(--purple-main), var(--purple-light));
        color: #fff;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(111, 66, 193, 0.3);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .small-box:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 6px 20px rgba(111, 66, 193, 0.45);
    }

    .small-box .inner {
        padding: 20px;
    }

    .small-box .inner h3 {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0;
    }

    .small-box .inner p {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .small-box .icon {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 3.5rem;
        opacity: 0.2;
    }

    .small-box-footer {
        display: block;
        text-align: center;
        padding: 10px 0;
        background: rgba(255, 255, 255, 0.15);
        color: #f3e8ff !important;
        font-weight: 500;
        transition: background 0.3s ease;
    }

    .small-box-footer:hover {
        background: rgba(255, 255, 255, 0.25);
        color: #fff !important;
    }

    /* Breadcrumb */
    .breadcrumb a {
        color: var(--purple-main);
        font-weight: 500;
        transition: color 0.2s;
    }

    .breadcrumb a:hover {
        color: var(--purple-dark);
    }

    .breadcrumb-item.active {
        color: var(--purple-dark);
    }
</style>

{{-- ===================== --}}
{{-- STATUS PESANAN --}}
{{-- ===================== --}}
<h5>Status Pesanan</h5>
<div class="row">
    <div class="col-12 col-sm-6 col-md-3 mb-4">
        <a href="{{ route('admin.orders.index') }}">
            <div class="info-box">
                <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Pesanan</span>
                    <span class="info-box-number">{{ $statusCounts['total'] }}</span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-12 col-sm-6 col-md-3 mb-4">
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}">
            <div class="info-box">
                <span class="info-box-icon" style="background: linear-gradient(145deg, #ffc107, #ffdb6e);"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending</span>
                    <span class="info-box-number">{{ $statusCounts['pending'] }}</span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-12 col-sm-6 col-md-3 mb-4">
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}">
            <div class="info-box">
                <span class="info-box-icon" style="background: linear-gradient(145deg, #007bff, #5c8eff);"><i class="fas fa-sync-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Processing</span>
                    <span class="info-box-number">{{ $statusCounts['processing'] }}</span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-12 col-sm-6 col-md-3 mb-4">
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}">
            <div class="info-box">
                <span class="info-box-icon" style="background: linear-gradient(145deg, #17a2b8, #58d0e6);"><i class="fas fa-truck"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Shipped</span>
                    <span class="info-box-number">{{ $statusCounts['shipped'] }}</span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-12 col-sm-6 col-md-3 mb-4">
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}">
            <div class="info-box">
                <span class="info-box-icon" style="background: linear-gradient(145deg, #28a745, #65d18d);"><i class="fas fa-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Completed</span>
                    <span class="info-box-number">{{ $statusCounts['completed'] }}</span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-12 col-sm-6 col-md-3 mb-4">
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}">
            <div class="info-box">
                <span class="info-box-icon" style="background: linear-gradient(145deg, #dc3545, #f57480);"><i class="fas fa-times"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Cancelled</span>
                    <span class="info-box-number">{{ $statusCounts['cancelled'] }}</span>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- ===================== --}}
{{-- MANAJEMEN SPAREPART --}}
{{-- ===================== --}}
<h5 class="mt-4">Manajemen Sparepart</h5>
<div class="row">
    <div class="col-lg-3 col-6">
        <a href="{{ route('admin.spareparts.index') }}">
            <div class="small-box">
                <div class="inner">
                    <h3>{{ $sparepartCount }}</h3>
                    <p>Jumlah Sparepart</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <span class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </span>
            </div>
        </a>
    </div>
</div>

@endsection
