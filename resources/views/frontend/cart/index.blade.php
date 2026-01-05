@extends('layouts.admin')

@section('title', 'Keranjang Belanja')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Keranjang</li>
    </ol>
@endsection

@section('content')
<style>
    /* 🌸 Tema Elegan */
    body {
        background-color: #f7f5fb;
        font-family: "Poppins", sans-serif;
        color: #3b2c59;
    }

    h2, h4 {
        font-weight: 600;
        color: #5b34a7;
    }

    .card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(111, 66, 193, 0.15);
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .table th {
        background-color: #ede7f6;
        color: #4b3c7d;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    .table td {
        vertical-align: middle;
    }

    .quantity-input {
        border-radius: 6px;
        border: 1px solid #c8b5f3;
        transition: 0.3s;
    }

    .quantity-input:focus {
        border-color: #7b43e0;
        box-shadow: 0 0 0 3px rgba(123, 67, 224, 0.15);
    }

    .btn-success {
        background-color: #6f42c1;
        border: none;
    }

    .btn-success:hover {
        background-color: #5b34a7;
        box-shadow: 0 0 10px rgba(111, 66, 193, 0.3);
    }

    .btn-outline-secondary:hover {
        background-color: #f3e9fc;
        color: #5b34a7;
    }

    .alert {
        border-radius: 10px;
    }

    .alert-info a {
        font-weight: 500;
        color: #6f42c1;
        text-decoration: none;
    }

    .alert-info a:hover {
        text-decoration: underline;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-center">🛒 Keranjang Belanja Anda</h2>

    {{-- ✅ Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    {{-- Logika utama keranjang --}}
    @php $total = 0; @endphp

    @if (session('cart') && count(session('cart')) > 0)
        <div class="row">
            {{-- 🧾 Kolom Kiri: Daftar Item --}}
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bordered mb-0 align-middle">
                            <thead class="table-light text-center">
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
                                        <td class="text-center">
                                            @if ($item['image'])
                                                <img src="{{ asset('storage/' . $item['image']) }}"
                                                    alt="{{ $item['name'] }}"
                                                    class="img-fluid rounded"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <img src="https://placehold.co/80x80/eeeeee/cccccc?text=No+Image"
                                                    alt="No Image" class="img-fluid rounded">
                                            @endif
                                        </td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td>
                                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex justify-content-center">
                                                @csrf
                                                <input type="hidden" name="sparepart_id" value="{{ $id }}">
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                    min="1"
                                                    class="form-control form-control-sm quantity-input text-center"
                                                    style="width: 70px;">
                                            </form>
                                        </td>
                                        <td><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 💰 Kolom Kanan: Ringkasan Pesanan --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-3">Ringkasan Pesanan</h4>
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <strong>Total Keseluruhan:</strong>
                                <strong class="text-success h5 mb-0">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </strong>
                            </li>
                        </ul>

                        {{-- Tombol Checkout / Login --}}
                        <div class="d-grid gap-2">
                            @auth
                                <form action="{{ route('checkout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg w-100">
                                        Lanjut ke Checkout
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-warning btn-lg w-100">
                                    Login untuk Checkout
                                </a>
                                <p class="text-center small text-muted mt-2">
                                    Anda harus login untuk melanjutkan pesanan.
                                </p>
                            @endauth

                            <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- 🛍️ Jika Keranjang Kosong --}}
        <div class="alert alert-info text-center shadow-sm">
            Keranjang belanja Anda kosong. 
            <a href="{{ route('home') }}">Ayo mulai belanja!</a>
        </div>
    @endif
</div>
@endsection
