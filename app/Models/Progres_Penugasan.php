<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progres_Penugasan extends Model
{
    protected $table = 'progres__penugasan';

    protected $fillable = [
        'penugasan_id',
        'keterangan_progres',
        'foto_bukti',
    ];
}
