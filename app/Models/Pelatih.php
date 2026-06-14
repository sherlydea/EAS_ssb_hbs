<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelatih extends Model
{
    protected $table = 'pelatihs';

    protected $fillable = [
        'user_id',
        'nama',
        'lisensi',
        'no_hp'
    ];

    /**
     * Hubungan relasi satu pelatih memiliki banyak jadwal latihan (One-to-Many)
     */
    public function jadwalLatihans()
    {
        return $this->hasMany(JadwalLatihan::class, 'pelatih_id');
    }
}