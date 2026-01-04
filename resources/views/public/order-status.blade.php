@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            @if($order->status === 'terkirim')
                <!-- Payment Success -->
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
                    <p class="text-gray-600">Terima kasih atas pembelian Anda</p>
                </div>

                <!-- Order Details -->
                <div class="border-t border-b border-gray-200 py-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Pesanan</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order ID:</span>
                            <span class="font-semibold">#{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Paket:</span>
                            <span class="font-semibold">{{ $order->paket->nama }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga:</span>
                            <span class="font-semibold">Rp {{ number_format($order->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                Berhasil
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Voucher Code -->
                @if($order->voucher)
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Kode Voucher Anda</h3>
                    <div class="bg-white rounded-lg p-4 border-2 border-dashed border-indigo-300">
                        <p class="text-3xl font-bold text-center text-indigo-600 tracking-wider">
                            {{ $order->voucher->code }}
                        </p>
                    </div>
                    <p class="text-sm text-gray-600 mt-3 text-center">
                        Kode voucher juga telah dikirim ke email: <strong>{{ $order->email }}</strong>
                    </p>
                </div>
                @endif

                <!-- Action Button -->
                <div class="text-center">
                    <a href="{{ route('welcome') }}" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Kembali ke Beranda
                    </a>
                </div>

            @elseif($order->status === 'menunggu')
                <!-- Payment Pending -->
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Menunggu Pembayaran</h1>
                    <p class="text-gray-600">Pesanan Anda belum dibayar</p>
                </div>

                <!-- Order Details -->
                <div class="border-t border-b border-gray-200 py-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Pesanan</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order ID:</span>
                            <span class="font-semibold">#{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Paket:</span>
                            <span class="font-semibold">{{ $order->paket->nama }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga:</span>
                            <span class="font-semibold">Rp {{ number_format($order->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                                Menunggu Pembayaran
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Instruksi Pembayaran</h3>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700">
                        <li>Silakan selesaikan pembayaran Anda</li>
                        <li>Setelah pembayaran berhasil, voucher akan dikirim ke email Anda</li>
                        <li>Proses verifikasi biasanya memakan waktu 1-5 menit</li>
                    </ol>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <a href="{{ route('welcome') }}" class="flex-1 text-center bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Kembali ke Beranda
                    </a>
                    <button onclick="location.reload()" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Refresh Status
                    </button>
                </div>

            @else
                <!-- Payment Failed/Cancelled -->
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Dibatalkan</h1>
                    <p class="text-gray-600">Pesanan Anda telah dibatalkan</p>
                </div>

                <!-- Order Details -->
                <div class="border-t border-b border-gray-200 py-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Pesanan</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order ID:</span>
                            <span class="font-semibold">#{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="text-center">
                    <a href="{{ route('welcome') }}" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
