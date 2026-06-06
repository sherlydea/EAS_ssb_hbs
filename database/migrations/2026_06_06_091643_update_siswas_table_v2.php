<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {

            $table->string('foto_siswa')->nullable()->after('alamat');

            $table->string('surat_izin_ortu')->nullable()->after('foto_siswa');

            $table->string('dokumen_pendukung')->nullable()->after('surat_izin_ortu');

            $table->enum(
                'status_verifikasi',
                ['Menunggu','Diterima','Ditolak']
            )->default('Menunggu')->after('dokumen_pendukung');

            $table->date('tanggal_daftar')
                  ->nullable()
                  ->after('status_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {

            $table->dropColumn([
                'foto_siswa',
                'surat_izin_ortu',
                'dokumen_pendukung',
                'status_verifikasi',
                'tanggal_daftar'
            ]);
        });
    }
};
