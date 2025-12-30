<?php
// app/Http/Controllers/DashboardController.php


namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ApiResponse;

    public function statistics()
    {
        $totalDokter = Dokter::count();
        $totalPasien = Pasien::count();

        $pasienPerDokter = Dokter::withCount('pasiens')
            ->get()
            ->map(function ($dokter) {
                return [
                    'nama' => $dokter->nama,
                    'spesialis' => $dokter->spesialis,
                    'jumlah_pasien' => $dokter->pasiens_count,
                ];
            });

        $pasienBulanan = Pasien::select(
            DB::raw('MONTH(tanggal_masuk) as bulan'),
            DB::raw('COUNT(*) as jumlah')
        )
            ->whereYear('tanggal_masuk', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $pasienTerbaru = Pasien::with('dokter')
            ->latest()
            ->limit(5)
            ->get();

        return $this->successResponse([
            'total_dokter' => $totalDokter,
            'total_pasien' => $totalPasien,
            'pasien_per_dokter' => $pasienPerDokter,
            'pasien_bulanan' => $pasienBulanan,
            'pasien_terbaru' => $pasienTerbaru,
        ]);
    }
}
