<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoneyJar extends Model
{
    protected $table = 'honey_jars';

    protected $fillable = [
        'user_id',
        'jar_name',
        'target_amount',
        'current_amount', // Tambahkan ini
        'deadline',
        'status',         // Tambahkan ini jika ada di database
    ];

    // Celengan ini mencatat banyak transaksi menabung
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Celengan ini milik seorang user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
