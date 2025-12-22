<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Paket;
use App\Models\Voucher;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        $pakets = Paket::count();
        $vouchers = Voucher::count();
        $orders = Order::count();

         // Debug: pastikan view file ada
    if (!view()->exists('admin.dashboard')) {
        dd('View admin.dashboard tidak ditemukan!');
    }

        return view('admin.dashboard', compact('pakets', 'vouchers', 'orders'));
    }
}

