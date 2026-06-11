<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanSpp extends Model
{
    use HasFactory;

    protected $table = 'tagihan_spps';

    protected $fillable = [
        'siswa_id',
        'bulan',
        'tahun',
        'nominal',
        'status',
        'catatan_admin',
        'bukti_pembayaran',
        'tanggal_bayar',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}