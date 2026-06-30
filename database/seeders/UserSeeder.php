<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Rika',
                'email' => 'rika@gmail.com.com',
                'email_verified_at' => now(),
                'roles' => 'admin', 
                'password' => Hash::make('12345678'), // Ganti dengan password yang aman                
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'email_verified_at' => now(),
                'roles' => 'user',
                'password' => Hash::make('password123'),                
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
