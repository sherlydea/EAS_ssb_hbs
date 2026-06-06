<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | PEMBAYARANS
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE pembayarans
            MODIFY status ENUM(
                'Menunggu',
                'Belum Bayar',
                'Menunggu Verifikasi',
                'Lunas',
                'Ditolak'
            ) NOT NULL DEFAULT 'Menunggu'
        ");

        DB::table('pembayarans')
            ->where('status', 'Menunggu')
            ->update(['status' => 'Menunggu Verifikasi']);

        DB::statement("
            ALTER TABLE pembayarans
            MODIFY status ENUM(
                'Belum Bayar',
                'Menunggu Verifikasi',
                'Lunas',
                'Ditolak'
            ) NOT NULL DEFAULT 'Belum Bayar'
        ");

        /*
        |--------------------------------------------------------------------------
        | TAGIHAN SPP
        |--------------------------------------------------------------------------
        */

        DB::statement("
            ALTER TABLE tagihan_spps
            MODIFY status ENUM(
                'Belum Bayar',
                'Menunggu Verifikasi',
                'Lunas',
                'Ditolak'
            ) NOT NULL DEFAULT 'Belum Bayar'
        ");

        Schema::table('tagihan_spps', function (Blueprint $table) {
            if (!Schema::hasColumn('tagihan_spps', 'catatan_admin')) {
                $table->text('catatan_admin')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE pembayarans
            MODIFY status ENUM(
                'Menunggu',
                'Lunas'
            ) NOT NULL DEFAULT 'Menunggu'
        ");

        DB::statement("
            ALTER TABLE tagihan_spps
            MODIFY status ENUM(
                'Belum Bayar',
                'Menunggu Verifikasi',
                'Lunas'
            ) NOT NULL DEFAULT 'Belum Bayar'
        ");

        Schema::table('tagihan_spps', function (Blueprint $table) {
            if (Schema::hasColumn('tagihan_spps', 'catatan_admin')) {
                $table->dropColumn('catatan_admin');
            }
        });
    }
};