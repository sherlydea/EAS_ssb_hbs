<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE siswas MODIFY kategori_latihan ENUM('U-10','U-13','U-15','U-18') NOT NULL");
        DB::statement("ALTER TABLE jadwal_latihans MODIFY kategori_latihan ENUM('U-10','U-13','U-15','U-18') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE siswas MODIFY kategori_latihan ENUM('U-10','U-12','U-15') NOT NULL");
        DB::statement("ALTER TABLE jadwal_latihans MODIFY kategori_latihan ENUM('U-10','U-12','U-15') NOT NULL");
    }
};