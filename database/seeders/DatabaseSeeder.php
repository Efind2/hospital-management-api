<?php
// database/seeders/DatabaseSeeder.php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Pasien;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat User Admin
        User::create([
            'name' => 'Admin Hospital',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buat User Staff
        User::create([
            'name' => 'Staff Hospital',
            'email' => 'staff@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Buat Dokter
        $dokter1 = Dokter::create([
            'nama' => 'Dr. Ahmad Wijaya, Sp.PD',
            'spesialis' => 'Penyakit Dalam',
            'no_telepon' => '081234567890',
            'jadwal' => ['Senin', 'Rabu', 'Jumat'],
        ]);

        $dokter2 = Dokter::create([
            'nama' => 'Dr. Siti Rahayu, Sp.A',
            'spesialis' => 'Anak',
            'no_telepon' => '081234567891',
            'jadwal' => ['Selasa', 'Kamis', 'Sabtu'],
        ]);

        $dokter3 = Dokter::create([
            'nama' => 'Dr. Budi Santoso, Sp.JP',
            'spesialis' => 'Jantung',
            'no_telepon' => '081234567892',
            'jadwal' => ['Senin', 'Rabu', 'Kamis'],
        ]);

        $dokter4 = Dokter::create([
            'nama' => 'Dr. Maya Kusuma, Sp.OG',
            'spesialis' => 'Kandungan',
            'no_telepon' => '081234567893',
            'jadwal' => ['Selasa', 'Kamis', 'Jumat'],
        ]);

        $dokter5 = Dokter::create([
            'nama' => 'Dr. Andi Pratama, Sp.B',
            'spesialis' => 'Bedah',
            'no_telepon' => '081234567894',
            'jadwal' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
        ]);

        // Buat Pasien
        Pasien::create([
            'nama' => 'Andi Setiawan',
            'umur' => 45,
            'penyakit' => 'Diabetes Mellitus',
            'dokter_id' => $dokter1->id,
            'tanggal_masuk' => now()->subDays(10),
        ]);

        Pasien::create([
            'nama' => 'Siti Nurhaliza',
            'umur' => 8,
            'penyakit' => 'Demam Tinggi',
            'dokter_id' => $dokter2->id,
            'tanggal_masuk' => now()->subDays(5),
        ]);

        Pasien::create([
            'nama' => 'Bambang Pamungkas',
            'umur' => 55,
            'penyakit' => 'Hipertensi',
            'dokter_id' => $dokter3->id,
            'tanggal_masuk' => now()->subDays(7),
        ]);

        Pasien::create([
            'nama' => 'Dewi Lestari',
            'umur' => 28,
            'penyakit' => 'Hamil 8 Bulan',
            'dokter_id' => $dokter4->id,
            'tanggal_masuk' => now()->subDays(3),
        ]);

        Pasien::create([
            'nama' => 'Rudi Hartono',
            'umur' => 35,
            'penyakit' => 'Apendisitis',
            'dokter_id' => $dokter5->id,
            'tanggal_masuk' => now()->subDays(2),
        ]);

        Pasien::create([
            'nama' => 'Fitri Handayani',
            'umur' => 12,
            'penyakit' => 'Asma',
            'dokter_id' => $dokter2->id,
            'tanggal_masuk' => now()->subDays(1),
        ]);

        Pasien::create([
            'nama' => 'Joko Widodo',
            'umur' => 60,
            'penyakit' => 'Kolesterol Tinggi',
            'dokter_id' => $dokter1->id,
            'tanggal_masuk' => now()->subDays(15),
        ]);

        Pasien::create([
            'nama' => 'Ani Yudhoyono',
            'umur' => 50,
            'penyakit' => 'Aritmia Jantung',
            'dokter_id' => $dokter3->id,
            'tanggal_masuk' => now()->subDays(4),
        ]);
    }
}