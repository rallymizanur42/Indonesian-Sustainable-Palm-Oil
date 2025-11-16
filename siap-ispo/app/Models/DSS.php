<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DSS extends Model
{
    use HasFactory;

    protected $table = 'd_s_s_es';
    protected $guarded = ['id'];

    protected $casts = [
        'skor_kesiapan' => 'decimal:2',
        'tanggal_dibuat' => 'datetime',
    ];

    public function pekebun()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(KriteriaISPO::class, 'kriteria_ispo_id');
    }

    public function riwayat()
    {
        return $this->hasOne(RiwayatDSS::class, 'dss_id');
    }

    public function pemetaanLahan()
    {
        return $this->belongsTo(PemetaanLahan::class, 'pemetaan_lahan_id');
    }
}
