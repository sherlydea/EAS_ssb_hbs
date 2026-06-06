<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan_jerseys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->string('tipe_jersey');
            $table->enum('ukuran', ['S', 'M', 'L', 'XL', 'XXL']);
            $table->string('nama_punggung')->nullable();
            $table->integer('nomor_punggung')->nullable();
            $table->integer('harga')->default(120000);
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan_jerseys');
    }
};