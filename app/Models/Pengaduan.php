<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    protected $table = 'pengaduan';

    protected $fillable = [
        'judul',
        'lokasi',
        'alamat',
        'kategori',
        'isi_laporan',
        'status',
    ];
}
