<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Kreiranje korisnika
        $userId = DB::table('users')->insertGetId([
            'name' => 'Admin User',
            'email' => 'fitrest@admin',
            'password' => Hash::make('password123'), // Promeni lozinku po potrebi
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dohvati ID admin role
        $roleId = DB::table('roles')->where('name', 'admin')->value('id');

        // Poveži korisnika sa admin rolom
        DB::table('user_role')->insert([
            'user_id' => $userId,
            'role_id' => $roleId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
