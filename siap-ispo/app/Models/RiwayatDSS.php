<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatDSS extends Model
{
    use HasFactory;

    protected $table = 'riwayat_d_s_s_es';
    protected $guarded = ['id'];

    protected $casts = [
        'skor_akhir' => 'decimal:2',
        'tanggal_analisis' => 'datetime',
    ];

    // Relasi ke user (pekebun)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke pemetaan lahan - INI ADA karena ada pemetaan_lahan_id
    public function pemetaanLahan()
    {
        return $this->belongsTo(PemetaanLahan::class, 'pemetaan_lahan_id');
    }

    // Relasi ke DSS record (satu riwayat punya satu DSS utama)
    public function dss()
    {
        return $this->belongsTo(DSS::class, 'dss_id');
    }

    // Relasi ke banyak DSS records - PERBAIKAN
    // Di model RiwayatDSS
public function dssRecords()
{
    return $this->hasMany(DSS::class, 'user_id', 'user_id')
                ->whereBetween('tanggal_dibuat', [
                    $this->tanggal_analisis->copy()->subHours(1),
                    $this->tanggal_analisis->copy()->addHours(1)
                ]);
}

    // Alias untuk kompatibilitas
    public function pekebun()
    {
        return $this->user();
    }
}