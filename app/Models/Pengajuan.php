<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nomor_pengajuan',
        'jenis_pengajuan',
        'deskripsi',
        'lampiran',
        'status',
    ];

    /**
     * Mendefinisikan relasi "belongs-to" ke model User.
     * Setiap pengajuan dimiliki oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi "one-to-one" ke model Respon.
     * Setiap pengajuan memiliki satu respon.
     */
    public function respon()
    {
        return $this->hasOne(Respon::class);
    }
}
