<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /** 
     * Menampilkan halaman keranjang belanja. 
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('frontend.cart.index', compact('cart'));
    }

    /** 
     * Menambahkan spare part ke keranjang. 
     */
    public function add(Sparepart $sparepart, Request $request)
    {
        // Ambil keranjang dari session (jika belum ada, gunakan array kosong)
        $cart = session()->get('cart', []);
        $id = $sparepart->id;

        // Validasi jumlah minimal 1
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);
        $quantityToAdd = $request->input('quantity', 1);

        // Gunakan accessor harga setelah diskon
        $effectivePrice = $sparepart->harga_setelah_diskon;

        if (isset($cart[$id])) {
            // Jika spare part sudah ada, tambahkan kuantitas
            $cart[$id]['quantity'] += $quantityToAdd;
        } else {
            // Jika spare part belum ada, tambahkan item baru
            $cart[$id] = [
                "name"          => $sparepart->nama,
                "quantity"      => $quantityToAdd,
                "price"         => $effectivePrice, // gunakan harga setelah diskon
                "image"         => $sparepart->gambar,
                "sparepart_id"  => $sparepart->id,
            ];
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', $sparepart->nama . ' berhasil ditambahkan ke keranjang.');
    }

    /** 
     * Memperbarui kuantitas item di keranjang. 
     */
    public function update(Request $request)
    {
        $request->validate([
            'sparepart_id' => 'required|exists:spareparts,id',
            'quantity'     => 'required|integer|min:1',
        ]);

        $id = $request->sparepart_id;
        $quantity = $request->quantity;
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Kuantitas diperbarui.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan.',
        ], 404);
    }

    /** 
     * Menghapus item dari keranjang. 
     */
    public function remove($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
