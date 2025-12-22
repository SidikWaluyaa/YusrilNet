<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel pakets
            $table->foreignId('paket_id')->constrained('pakets')->onDelete('cascade');
            // Menghubungkan ke tabel vouchers, bersifat nullable jika voucher belum dialokasikan
            $table->foreignId('voucher_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('email');
            $table->integer('harga');
            // Tambahkan snap_token untuk Midtrans
            $table->string('snap_token')->nullable();
            // Status order: misal 'menunggu', 'terkirim', 'batal'
            $table->enum('status', ['menunggu', 'terkirim', 'batal'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
