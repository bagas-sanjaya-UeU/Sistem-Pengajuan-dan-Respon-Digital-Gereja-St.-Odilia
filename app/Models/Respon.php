<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respon extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */
    protected $table = 'respons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pengajuan_id',
        'user_id', // ID user yang memberikan respon
        'catatan',
        'lampiran_respon',
    ];

    /**
     * Mendefinisikan relasi "belongs-to" ke model Pengajuan.
     * Setiap respon terkait dengan satu pengajuan.
     */
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    /**
     * Mendefinisikan relasi "belongs-to" ke model User.
     * Setiap respon diberikan oleh satu user (admin/pastor/dll).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
