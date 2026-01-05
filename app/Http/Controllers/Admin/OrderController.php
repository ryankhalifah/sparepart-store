<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua Pesanan (Read - Index).
     */
    public function index()
    {
        // Eager load relasi user dan orderItems serta sparepart untuk menghindari N+1 problem
        $orders = Order::with(['user', 'orderItems.sparepart'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Mengubah status pesanan.
     */
    public function updateStatus(Request $request, Order $order)
    {
        // 1. Validasi Input Status
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'shipped', 'completed', 'cancelled'])],
        ]);

        $newStatus = $request->status;
        $currentStatus = $order->status;

        $message = 'Status pesanan berhasil diubah.';

        // Logika Bisnis: Jika status diubah menjadi 'cancelled', kembalikan stok.
        if ($currentStatus !== 'cancelled' && $newStatus === 'cancelled') {
            // Lakukan pengembalian stok
            foreach ($order->orderItems ?? [] as $item) {
                $sparepart = Sparepart::find($item->sparepart_id);
                if ($sparepart) {
                    $sparepart->stok += $item->quantity ?? 0; // pastikan quantity ada
                    $sparepart->save();
                }
            }
            $message = 'Pesanan dibatalkan dan stok telah dikembalikan.';
        }

        // 2. Simpan Status Baru
        $order->status = $newStatus;
        $order->save();

        return back()->with('success', $message);
    }

    public function cancelOrder(Order $order, Request $request)
    {
        $user = $request->user();

        // Pastikan pesanan milik user
        if ($order->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak berhak membatalkan pesanan ini.');
        }

        // Cek status pesanan
        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Pesanan ini tidak bisa dibatalkan.');
        }

        // Kembalikan stok sparepart
        foreach ($order->orderItems as $item) {
            $sparepart = $item->sparepart;
            if ($sparepart) {
                $sparepart->stok += $item->jumlah;
                $sparepart->save();
            }
        }

        // Update status pesanan menjadi cancelled
        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
