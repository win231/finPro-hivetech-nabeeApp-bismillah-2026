<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        // 1. Ambil API Key yang disimpan di file .env
        $apiKey = env('NEWS_API_KEY');

        // 2. Tembak NewsAPI untuk mencari artikel bertema menabung (saving money)
        $response = Http::get('https://newsapi.org/v2/everything', [
            'q' => 'saving money',
            'language' => 'en',          // Artikel dalam bahasa Inggris sesuai request seeder kemarin
            'sortBy' => 'relevance',     // Cari artikel yang paling pas dengan tema
            'pageSize' => 6,             // Kita batasi cukup ambil 6 artikel saja
            'apiKey' => $apiKey
        ]);

        // 3. Ambil data artikelnya saja dari response JSON
        $articles = $response->json()['articles'] ?? [];

        // 4. Return data dalam bentuk JSON standar gaya penulisan Mentor kamu
        return response()->json([
            'Sukses' => 'Sukses mengambil artikel edukasi', // Menggunakan huruf kapital di depan
            'data' => $articles
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
