<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progres_Penugasan extends Model
{
    protected $table = 'progres__penugasan';
    public $timestamps = false; // Karena tabel progres__penugasan tidak memiliki created_at/updated_at

    protected $fillable = [
        'penugasan_id',
        'keterangan_progres',
        'foto_bukti',
    ];

    public function penugasan()
    {
        return $this->belongsTo(Penugasan::class, 'penugasan_id');
    }
}
