@extends('layouts.admin')

@section('title', 'Tambah Spare Part')

@section('content')
    {{-- Menampilkan notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- menampilkan notifikasi gagal --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container mt-3">
        <div class="shadow-sm card">
            <div class="text-white card-header bg-primary">
                <h4>Tambah Spare Part Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.spareparts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- PERBAIKAN: @csrf ditambahkan di sini -->
                    @include('admin.spareparts.form', ['sparepart' => new \App\Models\Sparepart()])
                    <button type="submit" class="mt-3 btn btn-success">Simpan</button>
                    <a href="{{ route('admin.spareparts.index') }}" class="mt-3 btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
