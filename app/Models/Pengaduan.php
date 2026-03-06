<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    protected $table = 'pengaduan';

    protected $fillable = [
        'lokasi',
        'alamat',
        'kategori',
        'isi_laporan',
        'foto_pengaduan',
        'status',
    ];

     const STATUS_PENDING = 'pending';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITOLAK = 'ditolak';

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'text-red-500',
            self::STATUS_DIPROSES => 'text-yellow-500',
            self::STATUS_SELESAI => 'text-green-600',
            self::STATUS_DITOLAK => 'text-gray-500',
            default => 'text-gray-500',
        };
    }
}
