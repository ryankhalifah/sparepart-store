<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik pelanggan yang sedang login.
     */
    public function myOrders(Request $request)
    {
        $user = $request->user();

        // Eager load relasi agar efisien (hindari N+1 problem)
        $orders = Order::with(['orderItems.sparepart'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    /**
     * Membatalkan pesanan (hanya bisa jika status pending/processing)
     */
    public function cancelOrder(Order $order, Request $request)
    {
        $user = $request->user();

        // Cek apakah pesanan milik user
        if ($order->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak berhak membatalkan pesanan ini.');
        }

        // Hanya pesanan dengan status tertentu yang bisa dibatalkan
        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Pesanan ini tidak bisa dibatalkan.');
        }

        // Pastikan relasi orderItems sudah dimuat agar stok bisa dikembalikan
        $order->load('orderItems.sparepart');

        // Kembalikan stok sparepart
        foreach ($order->orderItems as $item) {
            $sparepart = $item->sparepart;
            if ($sparepart) {
                $sparepart->increment('stok', $item->jumlah);
            }
        }

        // Update status pesanan menjadi cancelled
        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
