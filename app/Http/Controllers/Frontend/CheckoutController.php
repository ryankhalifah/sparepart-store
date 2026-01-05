<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class CheckoutController extends Controller
{
    /**
     * Memproses keranjang belanja (session) menjadi pesanan permanen di database.
     */
    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);

        // Pastikan keranjang tidak kosong
        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Pastikan pengguna terautentikasi
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Anda harus login untuk checkout.');
        }

        $totalPrice = 0;
        $secureCart = []; // Keranjang yang sudah diverifikasi harganya

        // Cek stok dan hitung ulang harga dari database
        foreach ($cart as $id => $details) {
            $sparepart = Sparepart::find($id);

            if (!$sparepart) {
                return back()->with('error', 'Spare part ' . $details['name'] . ' tidak lagi tersedia.');
            }

            if ($sparepart->stok < $details['quantity']) {
                return back()->with('error', 'Stok untuk ' . $details['name'] . ' tidak mencukupi. Sisa stok: ' . $sparepart->stok);
            }

            $priceUsed = $sparepart->harga_setelah_diskon;
            $subtotal  = $priceUsed * $details['quantity'];

            // Simpan data yang sudah diverifikasi ke secureCart
            $secureCart[$id] = [
                'sparepart_id' => $sparepart->id,
                'jumlah'       => $details['quantity'],
                'price_used'   => $priceUsed,
                'subtotal'     => $subtotal,
            ];

            $totalPrice += $subtotal;
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Buat data Order baru
            $order = Order::create([
                'user_id'     => Auth::id(),
                'total_harga' => $totalPrice,
                'status'      => 'pending',
            ]);

            // Tambahkan Order Items dan kurangi stok
            foreach ($secureCart as $id => $details) {
                $order->items()->create([
                    'sparepart_id' => $details['sparepart_id'],
                    'jumlah'       => $details['jumlah'],
                    'subtotal'     => $details['subtotal'],
                ]);

                $sparepart = Sparepart::find($id);
                $sparepart->stok -= $details['jumlah'];
                $sparepart->save();
            }

            // Kosongkan keranjang (session)
            session()->forget('cart');

            DB::commit();

            return redirect()
                ->route('home')
                ->with('success', 'Pesanan Anda dengan ID #' . $order->id . 
                    ' berhasil dibuat! Total: Rp' . number_format($totalPrice, 0, ',', '.'));
        } catch (Exception $e) {
            DB::rollBack();
            // Bisa tambahkan log error: \Log::error($e->getMessage());

            return back()
                ->with('error', 'Gagal memproses pesanan (' . $e->getMessage() . '). Silakan coba lagi.')
                ->withInput();
        }
    }
}
