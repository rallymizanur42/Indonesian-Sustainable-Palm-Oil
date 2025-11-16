<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi User (pekebun) ke PemetaanLahan (One-to-Many)
    public function pemetaanLahans()
    {
        return $this->hasMany(PemetaanLahan::class, 'user_id');
    }

    // Relasi User (pekebun) ke DSS (One-to-Many)
    public function dsses()
    {
        return $this->hasMany(DSS::class, 'user_id');
    }

    // Relasi User (pekebun) ke RiwayatDSS (One-to-Many)
    public function riwayatDsses()
    {
        return $this->hasMany(RiwayatDSS::class, 'user_id');
    }

    public function penilaianDSS()
    {
        return $this->hasMany(PenilaianDSS::class);
    }

    // Helper untuk Role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPekebun()
    {
        return $this->role === 'pekebun';
    }
}
