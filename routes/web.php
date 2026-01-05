<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SparepartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CustomerOrderController;

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (Bisa diakses SIAPA SAJA, termasuk tamu)
|--------------------------------------------------------------------------
*/

// Halaman utama toko
Route::get('/', [HomeController::class, 'index'])->name('home');

// Semua yang berhubungan dengan keranjang (dikelola via Session)
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('add/{sparepart}', [CartController::class, 'add'])->name('cart.add');
    Route::post('update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});


/*
|--------------------------------------------------------------------------
| RUTE AUTENTIKASI (Harus Login - Pelanggan & Admin)
|--------------------------------------------------------------------------
*/

// Halaman checkout, hanya bisa diakses setelah login
Route::post('checkout', [CheckoutController::class, 'processCheckout'])
    ->name('checkout')
    ->middleware('auth');

// Rute Profile User (Default Laravel)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute "Pengatur Lalu Lintas" setelah login
Route::get('/dashboard', function () {
    if (auth()->check()) {
        // Jika rolenya admin, lempar ke dashboard admin
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // --- INI PERBAIKANNYA ---
        // Jika rolenya BUKAN admin (pelanggan), lempar ke halaman HOME
        // Nama rute Anda adalah 'home', BUKAN 'frontend.index'
        return redirect()->route('home');
    }
    // Jika tidak terdeteksi, lempar ke login
    return redirect()->route('login');

    // JANGAN HAPUS BARIS INI:
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [CustomerOrderController::class, 'myOrders'])->name('frontend.myOrders');
    Route::post('/my-orders/{order}/cancel', [CustomerOrderController::class, 'cancelOrder'])->name('frontend.myOrders.cancel');
});



/*
|--------------------------------------------------------------------------
| RUTE KHUSUS ADMIN (HANYA Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin') // URL menjadi /admin/...
    ->name('admin.') // Nama rute menjadi admin....
    ->group(function () {

        // Dashboard Admin
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); // admin.dashboard

        // Manajemen Spare Part
        Route::get('spareparts', [SparepartController::class, 'index'])->name('spareparts.index');
        Route::get('spareparts/create', [SparepartController::class, 'create'])->name('spareparts.create');
        Route::post('spareparts', [SparepartController::class, 'store'])->name('spareparts.store');
        Route::get('spareparts/{sparepart}/edit', [SparepartController::class, 'edit'])->name('spareparts.edit');
        Route::patch('spareparts/{sparepart}', [SparepartController::class, 'update'])->name('spareparts.update');
        Route::delete('spareparts/{sparepart}', [SparepartController::class, 'destroy'])->name('spareparts.destroy');

        // Rute Manajemen Pesanan
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        // Rute Laporan Penjualan
        Route::get('reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    });

/*
|--------------------------------------------------------------------------
| Rute Bawaan Breeze (Login, Register, Dll)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
