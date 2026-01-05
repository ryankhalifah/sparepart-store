@extends('layouts.admin')

@section('title', 'Edit Spare Part')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right" style="background: transparent;">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #7f4acb;">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.spareparts.index') }}" style="color: #7f4acb;">Spare Part</a></li>
    <li class="breadcrumb-item active" style="color: #5e35b1;">Edit</li>
</ol>
@endsection

@section('content')
<style>
    /* ===== Tema Ungu Elegan ===== */
    body {
        background-color: #f8f5fc;
        font-family: 'Poppins', sans-serif;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(128, 0, 128, 0.1);
        background: #fff;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #7b42f6, #a25fd6);
        color: #fff;
        padding: 1.2rem 1.5rem;
        border-bottom: none;
    }

    .card-header h4 {
        font-weight: 600;
        margin: 0;
    }

    .card-body {
        background-color: #fcfaff;
        padding: 2rem;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #d1c4e9;
        box-shadow: none;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #7b42f6;
        box-shadow: 0 0 0 0.2rem rgba(123, 66, 246, 0.2);
    }

    label {
        font-weight: 500;
        color: #5e35b1;
    }

    .btn-success {
        background: linear-gradient(135deg, #8e24aa, #6a1b9a);
        border: none;
        color: #fff;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #9c27b0, #7b1fa2);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: #d1c4e9;
        color: #4a148c;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #b39ddb;
        color: #311b92;
        transform: translateY(-2px);
    }

    .alert-success {
        background-color: #e1bee7;
        border: none;
        color: #4a148c;
        font-weight: 500;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .alert-danger {
        background-color: #f8bbd0;
        border: none;
        color: #6a1b9a;
        font-weight: 500;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .shadow-sm {
        box-shadow: 0 5px 15px rgba(128, 0, 128, 0.08) !important;
    }
</style>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success text-center">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center">
        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
    </div>
@endif

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4><i class="fas fa-edit mr-2"></i>Edit Spare Part: {{ $sparepart->nama }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.spareparts.update', $sparepart) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH') 
                @include('admin.spareparts.form', ['sparepart' => $sparepart])

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Perbarui
                    </button>
                    <a href="{{ route('admin.spareparts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
