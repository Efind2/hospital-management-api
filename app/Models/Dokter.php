<?php
// app/Models/Dokter.php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'spesialis',
        'no_telepon',
        'jadwal',
    ];

    protected $casts = [
        'jadwal' => 'array',
    ];

    public function pasiens()
    {
        return $this->hasMany(Pasien::class);
    }
}