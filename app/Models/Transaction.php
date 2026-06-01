<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    // Tambahkan baris ini biar honey_jar_id dan amount diizinkan masuk database
    protected $fillable = [
        'honey_jar_id',
        'amount',
    ];

    // Transaksi ini milik celengan tertentu
    public function honeyJar()
    {
        return $this->belongsTo(HoneyJar::class);
    }
}
