<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transactions')->insert([
            [
                'honey_jar_id' => 1, // Masuk ke celengan ID 1
                'amount' => 100000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'honey_jar_id' => 1, // Masuk ke celengan ID 1 lagi
                'amount' => 50000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'honey_jar_id' => 2, // Masuk ke celengan ID 2
                'amount' => 300000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
