<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PublicOrderController;

Route::get('/', [PaketController::class, 'welcome'])->name('welcome');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =================== ROUTE PEMBELIAN PUBLIK (TANPA LOGIN) ===================
Route::get('/beli/{id}', [PublicOrderController::class, 'beli'])->name('public.beli');
Route::post('/order/store', [PublicOrderController::class, 'store'])->name('public.order.store');
Route::get('/order/success/{orderId}', [PublicOrderController::class, 'success'])->name('public.order.success');
Route::post('/ipaymu/callback', [PublicOrderController::class, 'handleCallback'])->name('ipaymu.callback');
Route::get('/order/callback', [PublicOrderController::class, 'handleReturnUrl'])->name('public.order.return');
Route::get('/order/cancel/{order_id}', [PublicOrderController::class, 'cancelOrder'])->name('public.order.cancel');

// =================== ADMIN ROUTE ===================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('pakets', PaketController::class);

    // Voucher routes
    Route::delete('/vouchers/destroy-all', [VoucherController::class, 'destroyAll'])->name('vouchers.destroyAll');
    Route::delete('/vouchers/destroy-selected', [VoucherController::class, 'destroySelected'])->name('vouchers.destroySelected');
    Route::delete('/vouchers/destroy-by-filter', [VoucherController::class, 'destroyByFilter'])->name('vouchers.destroyByFilter');
    Route::get('/vouchers/export', [VoucherController::class, 'export'])->name('vouchers.export');
    Route::get('/vouchers/import', [VoucherController::class, 'importForm'])->name('vouchers.import.form');
    Route::post('/vouchers/import', [VoucherController::class, 'import'])->name('vouchers.import');
    Route::get('/vouchers/template', [VoucherController::class, 'downloadTemplate'])->name('vouchers.template');
    Route::resource('vouchers', VoucherController::class);

    // Order routes khusus admin
    Route::get('/orders/print', [OrderController::class, 'printPdf'])->name('orders.print');
    Route::delete('/orders/delete-all', [OrderController::class, 'deleteAll'])->name('orders.deleteAll');
    Route::resource('orders', OrderController::class);



    // User management
    Route::resource('users', UserController::class);
});

Route::get('/voucher-tidak-tersedia', function () {
    return view('user.tidaktersedia');
})->name('tidaktersedia');

// =================== USER ROUTE ==================

// =================== UMUM ===================
Route::get('/publicdeskripsi/{id}', [PaketController::class, 'publicdeskripsi'])->name('publicdeskripsi');

require __DIR__.'/auth.php';
