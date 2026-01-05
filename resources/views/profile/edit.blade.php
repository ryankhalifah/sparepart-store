@extends('layouts.admin')

@section('title', 'Profil Pengguna')

@section('content')
<style>
    /* ===== Tema Ungu Lembut untuk Halaman Profil ===== */
    body {
        background-color: #f8f5fc;
        font-family: 'Poppins', sans-serif;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(128, 0, 128, 0.08);
        background: #fff;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(128, 0, 128, 0.12);
    }

    .card-header {
        background: linear-gradient(135deg, #7b42f6, #a25fd6);
        color: #fff;
        border-radius: 15px 15px 0 0;
        font-weight: 600;
        font-size: 1.1rem;
        padding: 0.9rem 1.25rem;
    }

    .section-title {
        font-weight: 600;
        color: #5e35b1;
        font-size: 1.25rem;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: #7e57c2;
    }

    .btn-primary {
        background: linear-gradient(135deg, #8e24aa, #6a1b9a);
        border: none;
        color: #fff;
        border-radius: 8px;
        padding: 8px 16px;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #9c27b0, #7b1fa2);
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 8px;
        border: none;
        font-weight: 500;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Update Profile --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-circle mr-2"></i> Perbarui Informasi Profil
                </div>
                <div class="card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-lock mr-2"></i> Ubah Kata Sandi
                </div>
                <div class="card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="card mb-4">
                <div class="card-header bg-danger bg-gradient text-white">
                    <i class="fas fa-user-slash mr-2"></i> Hapus Akun
                </div>
                <div class="card-body">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
