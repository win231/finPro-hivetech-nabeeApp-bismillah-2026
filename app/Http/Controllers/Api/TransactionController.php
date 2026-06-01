<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\HoneyJar;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth('sanctum')->id();

        // Mengambil semua transaksi dari celengan milik user yang sedang login
        // Dipasangkan dengan relasi 'honeyJar' biar bisa kelihatan nama celengannya
        $transactions = Transaction::whereHas('honeyJar', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orderBy('id', 'ASC')->get();

        return response()->json([
            'Status' => 'Sukses',
            'data' => $transactions
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk, kalau kosong atau salah format langsung error otomatis
        $request->validate([
            'honey_jar_id' => 'required|integer|exists:honey_jars,id',
            'amount' => 'required|integer|min:1000',
        ]);

        $userId = auth('sanctum')->id();

        // Pakai DB Transaction biar proses nambah tabungan dan update lebah aman terkendali
        DB::beginTransaction();

        try {
            // 2. Simpan data transaksi baru lewat Model Eloquent
            Transaction::create([
                'honey_jar_id' => $request->honey_jar_id,
                'amount' => $request->amount,
            ]);

            // 3. Tambahkan saldo celengan di tabel honey_jars
            $honeyJar = HoneyJar::find($request->honey_jar_id);
            if ($honeyJar) {
                $honeyJar->increment('current_amount', $request->amount);
            }

            // 4. LOGIC KARAKTER LEBAH: Ubah mood jadi happy, update tanggal, dan tambah +10 XP
            $character = Character::where('user_id', $userId)->first();

            if ($character) {
                $newXp = $character->xp + 10;
                $newType = $character->type;

                // Evolusi lebah otomatis kalau XP sudah menyentuh angka 30
                if ($newXp >= 30 && $character->type === 'Larva') {
                    $newType = 'Baby Bee';
                }

                $character->update([
                    'current_mood' => 'happy', // Berubah jadi happy pas sukses nabung!
                    'last_saved_date' => now()->toDateString(),
                    'xp' => $newXp,
                    'type' => $newType,
                ]);
            }

            DB::commit(); // Kunci semua perubahan data ke database

            // 5. Nampilin data transaksi paling baru yang barusan masuk, lengkap dengan relasinya
            $transaction = Transaction::with('honeyJar')->latest()->first();

            return response()->json([
                'sukses' => 'Sukses menambahkan data transaksi menabung, Buzzy senang sekali! 🐝🎉',
                'data' => $transaction
            ], 201); // 201 untuk response berhasil membuat data (POST)

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error di tengah jalan
            return response()->json([
                'Status' => 'Gagal menambahkan transaksi',
                'Pesan' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'Status' => 'Gagal mencari transaksi',
                'Pesan' => 'Data transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'Sukses' => 'Sukses menemukan data transaksi',
            'data' => $transaction
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Riwayat transaksi uang tidak boleh diubah demi keamanan data
        return response()->json([
            'Status' => 'Gagal mengupdate transaksi',
            'Pesan' => 'Riwayat transaksi menabung tidak bisa diubah!'
        ], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Riwayat transaksi uang tidak boleh dihapus biar tidak manipulatif
        return response()->json([
            'Status' => 'Gagal menghapus transaksi',
            'Pesan' => 'Riwayat transaksi tidak boleh dihapus!'
        ], 403);
    }
}
