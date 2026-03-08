<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Definisikan Konstanta Role di sini
    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_KONSUMEN = 'konsumen';
    public const ROLE_KEPALA_BAGIAN = 'kepala_bagian';
    public const ROLE_ADMIN_PENANGANAN = 'admin_penanganan';

    /**
     * Dapatkan daftar role yang valid
     */
    public static function getValidRoles(): array
    {
        return [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_KONSUMEN,
            self::ROLE_KEPALA_BAGIAN,
            self::ROLE_ADMIN_PENANGANAN,
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(profile::class);
    }
}
