{{-- Menggunakan layout default Breeze 'app.blade.php' --}}
@extends('layouts.admin')

@section('title', 'Home')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    </ol>
@endsection

@section('content')

<div class="container py-5">

{{-- Menampilkan notifikasi sukses --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- menampilkan notifikasi gagal --}}
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- Judul Halaman --}}
<h2 class="mb-4">Daftar Spare Part</h2>

{{-- Form Filter/Pencarian Sederhana --}}
<form action="{{ route('home') }}" method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-8">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode spare part..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </div>
</form>

{{-- Daftar Produk --}}
<div class="row">
    @forelse($spareparts as $sparepart)
    <div class="mb-4 col-md-4 col-lg-3">
        <div class="border-0 rounded-lg shadow-sm card h-100">
            
            {{-- PERBAIKAN: Menambahkan 'storage/' --}}
            <img src="{{ $sparepart->gambar ? asset('storage/' . $sparepart->gambar) : 'https://placehold.co/600x400/eeeeee/cccccc?text=No+Image' }}" 
                 class="card-img-top" 
                 alt="{{ $sparepart->nama }}" 
                 style="height: 200px; object-fit: cover;">
            
            <div class="card-body d-flex flex-column">
                <h5 class="card-title" style="font-size: 1.1rem;">{{ $sparepart->nama }}</h5>
                <p class="card-text text-muted small">{{ $sparepart->kategori }}</p>

                {{-- Logika Harga dan Diskon --}}
                @if($sparepart->diskon > 0)
                    <p class="mb-0 card-text text-danger">
                        <del>Rp {{ number_format($sparepart->harga, 0, ',', '.') }}</del> 
                        <span class="badge bg-warning text-dark">{{ $sparepart->diskon }}% OFF</span>
                    </p>
                    <p class="card-text text-success fw-bold" style="font-size: 1.25rem;">
                        {{-- Asumsi Anda punya accessor 'harga_setelah_diskon' di Model --}}
                        Rp {{ number_format($sparepart->harga_setelah_diskon, 0, ',', '.') }} 
                    </p>
                @else
                    <p class="card-text fw-bold" style="font-size: 1.25rem;">Rp {{ number_format($sparepart->harga, 0, ',', '.') }}</p>
                @endif

                <p class="pt-2 mt-auto card-text"><small class="text-muted">Stok: {{ $sparepart->stok }}</small></p>

                {{-- Form Tambah ke Keranjang --}}
                <form action="{{ route('cart.add', $sparepart) }}" method="POST" class="mt-2">
                    @csrf
                    {{-- input quantity opsional --}}
                    <input type="number" name="quantity" value="1" min="1" max="{{ $sparepart->stok }}" class="mb-2 form-control form-control-sm w-50" @if($sparepart->stok == 0) disabled @endif>
                    
                    <button type="submit" class="btn btn-primary w-100" @if($sparepart->stok == 0) disabled @endif>
                        @if($sparepart->stok == 0)
                            Stok Habis
                        @else
                            {{-- Pastikan layout Anda memuat Font Awesome --}}
                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center alert alert-info">
            Produk tidak ditemukan.
        </div>
    </div>
    @endforelse
</div>

{{-- Link Paginasi --}}
<div class="mt-4 d-flex justify-content-center">
    {{ $spareparts->appends(request()->query())->links() }}
</div>


</div>
@endsection