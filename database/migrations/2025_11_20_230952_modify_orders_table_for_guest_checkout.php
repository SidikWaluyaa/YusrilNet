<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Mengubah kolom user_id agar boleh null (nullable)
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Mengembalikan seperti semula (jika diperlukan)
            // Peringatan: Ini bisa gagal jika sudah ada data null
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
