<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@dairyfarm.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '+1234567890',
            'address' => 'Main Farm Address',
            'email_verified_at' => now(),
        ]);

        // Create a sample farmer user
        User::create([
            'name' => 'John Farmer',
            'email' => 'farmer@dairyfarm.com',
            'password' => Hash::make('password123'),
            'role' => 'farmer',
            'phone' => '+1987654321',
            'address' => 'Farm Section A',
            'email_verified_at' => now(),
        ]);
    }
}
