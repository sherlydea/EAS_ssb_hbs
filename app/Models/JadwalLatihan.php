<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalLatihan extends Model
{
    protected $table = 'jadwal_latihans';

    protected $fillable = [
        'pelatih_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kategori_latihan',
        'lokasi'
    ];

   public function pelatih()
{
    return $this->belongsTo(Pelatih::class, 'pelatih_id');
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
    
}