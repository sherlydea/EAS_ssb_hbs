<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom role ke users jika belum ada
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'pelatih', 'siswa'])->default('siswa')->after('password');
            });
        }

        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->enum('kategori_latihan', ['U-10', 'U-12', 'U-15']);
            $table->string('no_hp')->nullable();
            $table->string('nama_orang_tua')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });

        Schema::create('pelatihs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama');
            $table->string('lisensi')->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });

        Schema::create('jadwal_latihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatih_id')->nullable()->constrained('pelatihs')->nullOnDelete();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('kategori_latihan', ['U-10', 'U-12', 'U-15']);
            $table->string('lokasi');
            $table->timestamps();
        });

        Schema::create('turnamens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_turnamen');
            $table->date('tanggal');
            $table->string('lokasi');
            $table->enum('status', ['Terdaftar', 'Menunggu', 'Selesai'])->default('Menunggu');
            $table->timestamps();
        });

        Schema::create('jenis_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pembayaran');
            $table->integer('nominal');
            $table->timestamps();
        });

        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('jenis_pembayaran_id')->constrained('jenis_pembayarans')->cascadeOnDelete();
            $table->date('tanggal_bayar')->nullable();
            $table->integer('jumlah');
            $table->enum('status', ['Lunas', 'Menunggu'])->default('Menunggu');
            $table->timestamps();
        });

        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('jadwal_latihan_id')->nullable()->constrained('jadwal_latihans')->nullOnDelete();
            $table->date('tanggal');
            $table->enum('status', ['Hadir', 'Izin', 'Alpa']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
        Schema::dropIfExists('pembayarans');
        Schema::dropIfExists('jenis_pembayarans');
        Schema::dropIfExists('turnamens');
        Schema::dropIfExists('jadwal_latihans');
        Schema::dropIfExists('pelatihs');
        Schema::dropIfExists('siswas');

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};