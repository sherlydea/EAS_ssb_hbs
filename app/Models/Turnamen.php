<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turnamen extends Model
{
    protected $table = 'turnamens';

    protected $fillable = [
        'nama_turnamen',
        'tanggal',
        'lokasi',
        'status',
    ];
}