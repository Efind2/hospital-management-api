<?php
// app/Http/Controllers/DokterController.php


namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Dokter::withCount('pasiens');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('spesialis', 'like', "%{$search}%");
            });
        }

        $dokters = $query->paginate(10);

        return $this->successResponse($dokters);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'jadwal' => 'required|array',
        ]);

        $dokter = Dokter::create($validated);

        return $this->successResponse($dokter, 'Dokter created successfully', 201);
    }

    public function show(Dokter $dokter)
    {
        $dokter->load('pasiens');
        return $this->successResponse($dokter);
    }

    public function update(Request $request, Dokter $dokter)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'spesialis' => 'sometimes|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'jadwal' => 'sometimes|array',
        ]);

        $dokter->update($validated);

        return $this->successResponse($dokter, 'Dokter updated successfully');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return $this->successResponse(null, 'Dokter deleted successfully');
    }

    public function pasiens(Dokter $dokter)
    {
        $pasiens = $dokter->pasiens()->paginate(10);
        return $this->successResponse($pasiens);
    }
}