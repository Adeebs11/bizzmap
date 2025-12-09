<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Telkom',
            'email' => 'admin@telkom.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
