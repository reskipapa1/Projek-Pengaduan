<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    protected $table = 'penugasan';
    public $timestamps = false; // Karena tabel penugasan tidak memiliki created_at/updated_at

    protected $fillable = [
        'pengaduan_id',
        'petugas_id',
        'status_penugasan',
        'penugasan_dilakukan',
        'penugasan_selesai',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function progres()
    {
        return $this->hasMany(Progres_Penugasan::class, 'penugasan_id');
    }
}
