<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash; 
 
class UserSeeder extends Seeder 
{ 
    public function run(): void 
    { 
        DB::table('users')->insert([ 
            'name' => 'Admin Toko', 
            'email' => 'admin@toko.com', 
            'password' => Hash::make('password'), 
            'role' => 'admin', 
            'email_verified_at' => now(), 
        ]); 
         
        DB::table('users')->insert([ 
            'name' => 'Pelanggan Biasa', 
            'email' => 'pelanggan@toko.com', 
            'password' => Hash::make('password'), 
            'role' => 'pelanggan', 
            'email_verified_at' => now(), 
        ]); 
} 
}