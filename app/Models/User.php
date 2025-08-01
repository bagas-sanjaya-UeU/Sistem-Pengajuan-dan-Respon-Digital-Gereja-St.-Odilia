<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role', // Menggunakan 'role' sesuai migrasi terakhir
        'telp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    /**
     * Mendefinisikan relasi "one-to-many" ke model Pengajuan.
     * Seorang user bisa memiliki banyak pengajuan.
     */
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }

    /**
     * Mendefinisikan relasi "one-to-many" ke model Respon.
     * Seorang user (admin/pastor/dll) bisa memberikan banyak respon.
     */
    public function respons()
    {
        return $this->hasMany(Respon::class);
    }
}
