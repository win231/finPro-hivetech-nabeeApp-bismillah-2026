<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('characters')->insert([
            [
                'user_id' => 1,            // Diberikan kepada Windy Nabee (User ID 1)
                'name' => 'Buzzy',          // Nama lebahnya Windy, bebas mau diganti apa aja
                'type' => 'Larva',          // Sesuai request-mu, level 1 tipenya Larva
                'xp' => 0,                  // XP awal 0
                'current_mood' => 'neutral', // Mood awal neutral
                'last_saved_date' => null,  // Belum pernah nabung di awal
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
