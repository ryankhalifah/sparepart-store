@extends('layouts.admin')

@section('title', 'Keranjang Belanja')

@section('content')
<style>
    /* ===== Tema Ungu Elegan untuk Halaman Keranjang ===== */
    body {
        background-color: #f8f5fc;
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        color: #5e35b1;
        font-weight: 700;
    }

    .table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(128, 0, 128, 0.08);
    }

    .table thead {
        background: linear-gradient(135deg, #7b42f6, #a25fd6);
        color: #fff;
    }

    .table tbody tr:hover {
        background-color: #f3e5f5;
        transition: 0.3s;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(128, 0, 128, 0.08);
    }

    .card-body h4 {
        color: #6a1b9a;
        font-weight: 600;
    }

    .alert {
        border: none;
        border-radius: 10px;
        font-weight: 500;
        padding: 12px 18px;
    }

    .alert-success {
        background-color: #e1bee7;
        color: #4a148c;
    }

    .alert-danger {
        background-color: #f8bbd0;
        color: #880e4f;
    }

    .alert-info {
        background-color: #ede7f6;
        color: #4527a0;
    }

    .btn-success {
        background: linear-gradient(135deg, #8e24aa, #6a1b9a);
        border: none;
        color: #fff;
        border-radius: 10px;
        padding: 10px 16px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #9c27b0, #7b1fa2);
        transform: translateY(-2px);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ab47bc, #8e24aa);
        border: none;
        color: #fff;
        border-radius: 8px;
        padding: 6px 12px;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #9c27b0, #6a1b9a);
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffb74d, #f57c00);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-weight: 600;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #ffa726, #ef6c00);
    }

    .quantity-input {
        border: 1px solid #d1c4e9;
        border-radius: 8px;
        text-align: center;
    }

    .quantity-input:focus {
        border-color: #7b1fa2;
        box-shadow: 0 0 0 0.1rem rgba(123, 31, 162, 0.25);
    }

    a {
        color: #6a1b9a;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

<div class="container py-5">
    <h2><i class="fas fa-shopping-cart me-2"></i> Keranjang Belanja Anda</h2>
    <hr>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger shadow-sm">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    @php $total = 0; @endphp

    @if (session('cart') && count(session('cart')) > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Spare Part</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (session('cart') as $id => $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>
                                @if ($item['image'])
                                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                        style="width: 55px; height: 55px; object-fit: cover; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                @endif
                            </td>
                            <td><strong>{{ $item['name'] }}</strong></td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.update') }}" method="POST"
                                    class="d-flex justify-content-center update-cart-form">
                                    @csrf
                                    <input type="hidden" name="sparepart_id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                        class="form-control quantity-input" style="width: 80px;">
                                </form>
                            </td>
                            <td><strong style="color:#6a1b9a;">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus item ini?')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Ringkasan Pesanan --}}
        <div class="mt-5 row">
            <div class="col-md-6 offset-md-6">
                <div class="card border-0">
                    <div class="card-body">
                        <h4 class="mb-3"><i class="fas fa-receipt me-2"></i> Ringkasan Pesanan</h4>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total Keseluruhan:</span>
                                <span class="fw-bold" style="color:#6a1b9a;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </li>
                        </ul>

                        @auth
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                                    <i class="fas fa-credit-card me-2"></i> Proses Checkout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning btn-lg w-100 shadow-sm">
                                <i class="fas fa-sign-in-alt me-2"></i> Login untuk Checkout
                            </a>
                            <p class="mt-2 text-center text-muted">
                                Anda harus login untuk melanjutkan pesanan.
                            </p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="text-center alert alert-info mt-4 shadow-sm">
            <i class="fas fa-info-circle me-2"></i>
            Keranjang belanja Anda kosong.
            <a href="{{ route('home') }}" class="fw-bold">Ayo mulai belanja!</a>
        </div>
    @endif
</div>
@endsection
