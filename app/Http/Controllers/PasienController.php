<?php
// app/Http/Controllers/PasienController.php


namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Pasien::with('dokter');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('penyakit', 'like', "%{$search}%");
            });
        }

        if ($request->has('dokter_id')) {
            $query->where('dokter_id', $request->dokter_id);
        }

        $pasiens = $query->latest()->paginate(10);

        return $this->successResponse($pasiens);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'penyakit' => 'required|string|max:255',
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal_masuk' => 'required|date',
        ]);

        $pasien = Pasien::create($validated);
        $pasien->load('dokter');

        return $this->successResponse($pasien, 'Pasien created successfully', 201);
    }

    public function show(Pasien $pasien)
    {
        $pasien->load('dokter');
        return $this->successResponse($pasien);
    }

    public function update(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'umur' => 'sometimes|integer|min:0',
            'penyakit' => 'sometimes|string|max:255',
            'dokter_id' => 'sometimes|exists:dokters,id',
            'tanggal_masuk' => 'sometimes|date',
        ]);

        $pasien->update($validated);
        $pasien->load('dokter');

        return $this->successResponse($pasien, 'Pasien updated successfully');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return $this->successResponse(null, 'Pasien deleted successfully');
    }

    public function changeDokter(Request $request, Pasien $pasien)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokters,id',
        ]);

        $pasien->update(['dokter_id' => $request->dokter_id]);
        $pasien->load('dokter');

        return $this->successResponse($pasien, 'Dokter changed successfully');
    }
}