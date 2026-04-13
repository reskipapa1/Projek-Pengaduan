<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'Nik',
        'name',
        'no_telp',
        'alamat',
        'foto_profil',
        'lokasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
