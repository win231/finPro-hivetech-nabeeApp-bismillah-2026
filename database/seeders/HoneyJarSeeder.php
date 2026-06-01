<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HoneyJarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('honey_jars')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'jar_name' => 'Beli Sepatu Baru', // <--- Sesuai: jar_name
                'target_amount' => 500000.00,
                'current_amount' => 150000.00,
                'deadline' => '2026-12-31',       // <--- Sesuai: deadline (format YYYY-MM-DD)
                'status' => 'active',             // <--- Sesuai: status
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'jar_name' => 'Dana Darurat Lebah',
                'target_amount' => 1000000.00,
                'current_amount' => 300000.00,
                'deadline' => '2027-06-30',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
