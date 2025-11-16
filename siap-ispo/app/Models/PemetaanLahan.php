<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemetaanLahan extends Model
{
    use HasFactory;

    protected $table = 'pemetaan_lahans';

    // TAMBAHKAN FILLABLE ATAU GUARDED
    protected $fillable = [
        'id_lahan',
        'user_id',
        'deskripsi',
        'desa',
        'kecamatan',
        'status_ispo',
        'tingkat_kesiapan',
        'luas_lahan',
        'geometry_type',
        'geometry'
    ];

    // Relasi PemetaanLahan ke User (Many-to-One)
    public function pekebun()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi PemetaanLahan ke RiwayatDSS (One-to-Many)
    public function riwayatDsses()
    {
        return $this->hasMany(RiwayatDSS::class, 'pemetaan_lahan_id');
    }
}
