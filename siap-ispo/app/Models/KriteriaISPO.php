<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaISPO extends Model
{
    use HasFactory;

    protected $table = 'kriteria_ispo';
    protected $guarded = ['id'];

    protected $casts = [
        'bobot' => 'decimal:2',
    ];

    public function dsses()
    {
        return $this->hasMany(DSS::class, 'kriteria_ispo_id');
    }

    public function penilaian()
    {
        return $this->hasMany(PenilaianDSS::class, 'kriteria_id');
    }
}
