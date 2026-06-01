<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\HoneyJarController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route untuk Auth - Gaya Penulisan Mentor
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

// Route untuk fitur Artikel Menabung (NewsAPI)
Route::get('/api-articles', [ArticleController::class, 'index'])->middleware('auth:sanctum');

// Route untuk Honey Jars (Celengan)
Route::apiResource('/api-honey-jars', HoneyJarController::class)->middleware('auth:sanctum');

// Route untuk Transactions (Riwayat Nabung)
Route::apiResource('/api-transactions', TransactionController::class)->middleware('auth:sanctum');

// harus selalu ngeliat lewat route list di terminal