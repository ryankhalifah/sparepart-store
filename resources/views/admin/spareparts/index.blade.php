@extends('layouts.admin')

@section('title', 'Manajemen Spare Part')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right" style="background: transparent;">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}" style="color: #7f4acb;">Dashboard</a>
        </li>
        <li class="breadcrumb-item active" style="color: #5e35b1;">Manajemen Spare Part</li>
    </ol>
@endsection

@section('content')
<style>
    /* 🌸 ===== Tema Ungu Elegan Admin ===== 🌸 */
    body {
        background-color: #f8f5fc;
        font-family: 'Poppins', sans-serif;
        color: #3b2a57;
    }

    .card {
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 14px rgba(123, 66, 193, 0.08);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #7b42f6, #a25fd6);
        color: #fff;
        border: none;
        padding: 1rem 1.25rem;
        border-radius: 16px 16px 0 0;
    }

    .card-header .card-title {
        font-weight: 600;
        font-size: 1.25rem;
        margin: 0;
    }

    .btn-success {
        background: linear-gradient(135deg, #9c27b0, #7b1fa2);
        border: none;
        color: #fff;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #8e24aa, #6a1b9a);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(111, 66, 193, 0.2);
    }

    .btn-info {
        background: linear-gradient(135deg, #7e57c2, #5e35b1);
        border: none;
        color: #fff;
        border-radius: 8px;
        padding: 6px 12px;
        transition: 0.3s ease;
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #6a1b9a, #512da8);
        transform: translateY(-2px);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ab47bc, #8e24aa);
        border: none;
        color: #fff;
        border-radius: 8px;
        padding: 6px 12px;
        transition: 0.3s ease;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #9c27b0, #6a1b9a);
        transform: translateY(-2px);
    }

    .table thead {
        background: #ede7f6;
        color: #4a148c;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr:hover {
        background-color: #f3e5f5;
        transition: background 0.3s;
    }

    .table td, .table th {
        vertical-align: middle;
    }

    .badge {
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 0.85rem;
    }

    .alert-success {
        background-color: #e9d7f7;
        color: #5e35b1;
        border: none;
        border-radius: 10px;
        font-weight: 500;
        box-shadow: 0 2px 10px rgba(111, 66, 193, 0.1);
    }

    .pagination .page-link {
        color: #7b1fa2;
        border-radius: 6px;
        margin: 0 3px;
        transition: all 0.3s;
    }

    .pagination .page-link:hover {
        background-color: #ede7f6;
    }

    .pagination .page-item.active .page-link {
        background-color: #7b1fa2;
        border-color: #7b1fa2;
        color: #fff;
        box-shadow: 0 0 6px rgba(111, 66, 193, 0.4);
    }
</style>

<div class="content-header mb-3 d-flex justify-content-between align-items-center">
    <h2 class="fw-semibold text-purple mb-0">
        <i class="fas fa-tools me-2"></i> Manajemen Spare Part
    </h2>
    <a href="{{ route('admin.spareparts.create') }}" class="btn btn-success shadow-sm">
        <i class="fas fa-plus"></i> Tambah Spare Part
    </a>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-cogs me-2"></i> Daftar Spare Part</h3>
        </div>

        <div class="card-body table-responsive p-3">
            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="alert alert-success text-center">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <table class="table table-hover align-middle text-nowrap">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Diskon (%)</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($spareparts as $sparepart)
                        <tr class="text-center">
                            <td>{{ $sparepart->id }}</td>
                            <td>
                                @if ($sparepart->gambar)
                                    <img src="{{ asset('storage/' . $sparepart->gambar) }}"
                                        alt="{{ $sparepart->nama }}"
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{ $sparepart->kode }}</td>
                            <td><strong>{{ $sparepart->nama }}</strong></td>
                            <td>{{ $sparepart->kategori }}</td>
                            <td>
                                <strong style="color:#6a1b9a;">
                                    Rp {{ number_format($sparepart->harga, 0, ',', '.') }}
                                </strong>
                            </td>
                            <td>{{ $sparepart->diskon }}%</td>
                            <td>
                                <span class="badge {{ $sparepart->stok > 10 ? 'bg-success' : ($sparepart->stok > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $sparepart->stok }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.spareparts.edit', $sparepart) }}" class="btn btn-sm btn-info me-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.spareparts.destroy', $sparepart) }}" method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                Tidak ada data spare part.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $spareparts->links() }}
        </div>
    </div>
</div>
@endsection
