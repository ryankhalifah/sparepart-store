<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /** 
     * Menampilkan laporan penjualan sederhana berdasarkan status 'completed'. 
     */
    public function salesReport(Request $request)
    {
        // 1. Ambil data pesanan yang sudah selesai (completed) 
        $completedOrders = Order::with('user')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc');

        // 2. Filter Tanggal (Opsional: Latihan Mahasiswa) 
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $completedOrders->whereDate(
                'created_at',
                '>=',
                $startDate
            );
        }

        if ($endDate) {
            // Tambahkan 1 hari untuk mencakup tanggal akhir penuh 
            $completedOrders->whereDate(
                'created_at',
                '<=',
                $endDate
            );
        }

        $orders = $completedOrders->get();

        // 3. Hitung Total Pendapatan Keseluruhan (Aggregasi) 
        $totalRevenue = Order::where('status', 'completed')
            ->when($startDate, fn($query) =>
            $query->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($query) =>
            $query->whereDate('created_at', '<=', $endDate))
            ->sum('total_harga');

        return view('admin.reports.sales', [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
