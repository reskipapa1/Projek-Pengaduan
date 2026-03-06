<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lps extends Model
{
    protected $table = 'lps';

    protected $fillable = [
        'nama_lps',
        'wilayah_layanan',
        'status_operasional',
    ];  
}
