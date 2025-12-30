<?php
// app/Models/Pasien.php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'umur',
        'penyakit',
        'dokter_id',
        'tanggal_masuk',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}