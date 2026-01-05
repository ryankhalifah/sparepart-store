<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Sparepart;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung pesanan berdasarkan status
        $statusCounts = [
            'pending'    => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped'    => Order::where('status', 'shipped')->count(),
            'completed'  => Order::where('status', 'completed')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
            'total'      => Order::count(),
        ];

        // Hitung jumlah sparepart
        $sparepartCount = Sparepart::count();

        return view('admin.dashboard.index', compact('statusCounts', 'sparepartCount'));
    }
}
