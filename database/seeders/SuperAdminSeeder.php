<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'display_name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // Change this to a secure password
            'role' => 'super_admin',
            'status' => 'active',
            'bio' => 'System Super Administrator',
        ]);
    }
}
