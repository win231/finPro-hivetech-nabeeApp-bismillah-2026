<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            array(
                'name' => 'jaro',
                'email' => 'jaro@gmail.com',
                'password' => Hash::make('12345678')
            ),
            array(
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678')
            ),
        ]);
    }
}
