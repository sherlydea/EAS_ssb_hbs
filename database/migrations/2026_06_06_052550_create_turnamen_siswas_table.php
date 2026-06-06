<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('turnamen_siswas')) {
    Schema::create('turnamen_siswas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
        $table->foreignId('turnamen_id')->constrained('turnamens')->cascadeOnDelete();
        $table->integer('biaya')->default(0);
        $table->string('bukti_pembayaran')->nullable();
        $table->enum('status_pembayaran', ['Belum Bayar','Menunggu Konfirmasi','Lunas'])->default('Belum Bayar');
        $table->enum('status_turnamen', ['Aktif','Selesai'])->default('Aktif');
        $table->timestamps();
    });
}
    }

    public function down(): void
    {
        Schema::dropIfExists('turnamen_siswas');
    }
};