<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananJersey extends Model
{
    protected $table = 'pesanan_jerseys';

    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}