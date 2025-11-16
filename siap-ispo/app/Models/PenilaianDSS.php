<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianDSS extends Model
{
    use HasFactory;

    protected $table = 'penilaian_d_s_s';
    protected $guarded = ['id'];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemetaanLahan()
    {
        return $this->belongsTo(PemetaanLahan::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(KriteriaISPO::class, 'kriteria_id');
    }
}
