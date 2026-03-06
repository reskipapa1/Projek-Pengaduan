<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    protected $table = 'penugasan';

    protected $fillable = [
        'pengaduan_id',
        'petugas_id',
        'status_penugasan',
        'penugasan_dilakukan',
        'penugasan_selesai',
    ];  
}
