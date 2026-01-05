<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan daftar spare part di halaman utama.
     */
    public function index(Request $request)
    {
        // Ambil data spare parts, terapkan filter pencarian/kategori jika ada.
        $spareparts = Sparepart::latest()->filter(
            $request->only(['search', 'category'])
        )->paginate(12); // Paginasi opsional

        // Ambil semua kategori unik (untuk filter)
        $categories = Sparepart::select('kategori')->distinct()->pluck('kategori');

        // =========================================
        // PERBAIKAN: 
        // Mengubah 'frontend.home.index' menjadi 'frontend.index' 
        // agar sesuai dengan struktur file Anda.
        // =========================================
        return view('frontend.index', [
            'spareparts' => $spareparts,
            'categories' => $categories,
        ]);
    }
}
