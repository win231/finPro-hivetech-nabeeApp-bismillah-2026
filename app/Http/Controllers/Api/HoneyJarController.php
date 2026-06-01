<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HoneyJar;
use Illuminate\Http\Request;

class HoneyJarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cek siapa user yang login biar gak ngintip celengan orang lain
        $userId = auth('sanctum')->id();

        // Ambil semua celengan milik user tersebut
        $honeyJars = HoneyJar::where('user_id', $userId)->orderBy('id', 'ASC')->get();

        return response()->json([
            'Status' => 'Sukses mengambil data celengan slebew',
            'data' => $honeyJars
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jar_name' => 'required|string',
            'target_amount' => 'required|integer|min:5000',
            'deadline' => 'required|date', // Tambahkan validasi deadline
        ]);

        $userId = auth('sanctum')->id();

        // Bikin celengan baru lewat Model Eloquent
        HoneyJar::create([
            'user_id' => $userId,
            'jar_name' => $request->jar_name,
            'target_amount' => $request->target_amount,
            'current_amount' => 0, // Biarkan default otomatis 0 tanpa perlu diketik di Postman
            'deadline' => $request->deadline, 
        ]);

        $newJar = HoneyJar::where('user_id', $userId)->latest()->first();

        return response()->json([
            'sukses' => 'Sukses menambahkan data celengan baru',
            'data' => $newJar
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = auth('sanctum')->id();
        $honeyJar = HoneyJar::where('user_id', $userId)->find($id);

        if (!$honeyJar) {
            return response()->json([
                'Status' => 'Gagal mencari celengan',
                'Pesan' => 'Celengan tidak ditemukan atau bukan milikmu'
            ]);
        }

        return response()->json([
            'Sukses' => 'Sukses menemukan celengan',
            'data' => $honeyJar
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $userId = auth('sanctum')->id();
        $honeyJar = HoneyJar::where('user_id', $userId)->find($id);

        if (!$honeyJar) {
            return response()->json([
                'Status' => 'Gagal mengupdate celengan',
                'Pesan' => 'Celengan tidak ditemukan'
            ]);
        }

        // Cuma boleh edit nama celengan atau naikin target tabungan
        $honeyJar->update([
            'jar_name' => $request->jar_name ?? $honeyJar->jar_name,
            'target_amount' => $request->target_amount ?? $honeyJar->target_amount,
        ]);

        return response()->json([
            'sukses' => 'Sukses mengupdate data celengan',
            'data' => $honeyJar
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userId = auth('sanctum')->id();
        $honeyJar = HoneyJar::where('user_id', $userId)->find($id);

        if (!$honeyJar) {
            return response()->json([
                'Status' => 'Gagal menghapus celengan',
                'Pesan' => 'Celengan tidak ditemukan'
            ]);
        }

        $honeyJar->delete();

        return response()->json([
            'Status' => 'Sukses',
            'Pesan' => 'Sukses menghapus data celengan',
        ], 200);
    }
}
