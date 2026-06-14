<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta_turnamens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('turnamen_id')
                ->constrained('turnamens')
                ->cascadeOnDelete();

            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->cascadeOnDelete();

            $table->foreignId('pelatih_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique(['turnamen_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_turnamens');
    }
};