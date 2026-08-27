<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::ensureColumns();

        User::updateOrCreate(
            ['email' => 'admin@cnci.com'],
            [
                'name' => 'CNCI Admin',
                'password' => 'Admin@123',
                'role' => User::ROLE_SUPER_ADMIN,
                'pastor_id' => null,
                'email_verified_at' => now(),
            ]
        );
    }
}
