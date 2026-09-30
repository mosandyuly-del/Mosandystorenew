<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mosandystore.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Admin@1998!'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );
    }
}
