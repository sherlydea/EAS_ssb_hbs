<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nama',
        'kategori_latihan',
        'no_hp',
        'tanggal_daftar',
        'status_verifikasi',
        'alamat',
        'nama_orang_tua'
    ];

    protected $dates = [
        'tanggal_daftar'
    ];

    public function tagihanSpps()
    {
        return $this->hasMany(TagihanSpp::class);
    }
}