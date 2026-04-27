<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();

            // relasi ke user
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // relasi ke buku
            $table->foreignId('buku_id')->constrained()->cascadeOnDelete();

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();

            $table->enum('status', ['dipinjam', 'dikembalikan'])
                  ->default('dipinjam');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};