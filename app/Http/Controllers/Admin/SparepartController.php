<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada
use Illuminate\Validation\Rule;

class SparepartController extends Controller
{
    /**
     * Menampilkan daftar semua Spare Part (Read - Index).
     */
    public function index()
    {
        $spareparts = Sparepart::latest()->paginate(10);
        return view('admin.spareparts.index', compact('spareparts'));
    }

    /**
     * Menampilkan form untuk membuat Spare Part baru (Create).
     */
    public function create()
    {
        return view('admin.spareparts.create');
    }

    /**
     * Menyimpan Spare Part baru ke database (Create - Store).
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Form
        $validatedData = $request->validate([
            'kode' => 'required|unique:spareparts|max:255',
            'nama' => 'required|max:255',
            'kategori' => 'required|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'diskon' => 'nullable|integer|min:0|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Inisialisasi path gambar
        $validatedData['gambar'] = null;

        // 2. Upload Gambar (CARA YANG DIPERBAIKI)
        if ($request->hasFile('gambar')) {
            // Perintah ini akan:
            // 1. Menyimpan file ke: 'storage/app/public/spareparts'
            // 2. Mengembalikan path: 'spareparts/namafile.jpg'
            $path = $request->file('gambar')->store('spareparts', 'public');
            $validatedData['gambar'] = $path;
        }

        // 3. Simpan Data
        Sparepart::create($validatedData);

        return redirect()->route('admin.spareparts.index')
                         ->with('success', 'Spare part berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit Spare Part (Update - Edit).
     */
    public function edit(Sparepart $sparepart)
    {
        return view('admin.spareparts.edit', compact('sparepart'));
    }

    /**
     * Memperbarui Spare Part di database (Update).
     */
    public function update(Request $request, Sparepart $sparepart)
    {
        // 1. Validasi Input Form
        $validatedData = $request->validate([
            'kode' => ['required', 'max:255', Rule::unique('spareparts')->ignore($sparepart->id)],
            'nama' => 'required|max:255',
            'kategori' => 'required|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'diskon' => 'nullable|integer|min:0|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil path gambar lama
        $validatedData['gambar'] = $sparepart->gambar;

        // 2. Upload Gambar Baru (jika ada) dan Hapus Gambar Lama (CARA YANG DIPERBAIKI)
        if ($request->hasFile('gambar')) {
            
            // Hapus gambar lama jika ada
            if ($sparepart->gambar) {
                // Hapus file dari disk 'public' menggunakan path lama (mis: 'spareparts/file.jpg')
                Storage::disk('public')->delete($sparepart->gambar);
            }

            // Simpan gambar baru
            $path = $request->file('gambar')->store('spareparts', 'public');
            $validatedData['gambar'] = $path;
        }

        // 3. Simpan Perubahan
        $sparepart->update($validatedData);

        return redirect()->route('admin.spareparts.index')
                         ->with('success', 'Spare part berhasil diperbarui.');
    }

    /**
     * Menghapus Spare Part dari database (Delete).
     */
    public function destroy(Sparepart $sparepart)
    {
        // Hapus file gambar terkait dari storage (CARA YANG DIPERBAIKI)
        if ($sparepart->gambar) {
            Storage::disk('public')->delete($sparepart->gambar);
        }

        // Hapus data sparepart
        $sparepart->delete();

        return redirect()->route('admin.spareparts.index')
                         ->with('success', 'Spare part berhasil dihapus.');
    }
}
