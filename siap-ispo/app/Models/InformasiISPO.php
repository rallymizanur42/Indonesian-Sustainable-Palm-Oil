<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiISPO extends Model
{
    use HasFactory;

    protected $table = 'informasi_ispo';

    protected $fillable = [
        'judul',
        'syarat_ispo',
        'deskripsi',
        'manfaat',
        'fitur',
        'gambar'
    ];
}
