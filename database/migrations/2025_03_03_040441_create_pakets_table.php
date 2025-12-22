<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id(); // ID (Auto Increment dan Primary Key)
            $table->string('nama'); // Nama Paket
            $table->integer('price'); // Harga Paket
            $table->integer('duration'); // Durasi
            $table->text('deskripsi'); // Deskripsi Paket
            $table->json('detail_paket'); // Detail Paket dalam JSON
            $table->integer('available'); // Tersedia atau Tidak (0 = Tidak, 1 = Tersedia)
            $table->integer('sold')->default(0); // Sudah Terjual
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
