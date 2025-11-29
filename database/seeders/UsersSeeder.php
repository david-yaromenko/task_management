<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'email' => 'admin@example.com',
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role_id' => 1,
            ]
        );

        User::create(
            [
                'email' => 'user@example.com',
                'name' => 'User',
                'password' => Hash::make('password'),
                'role_id' => 2,
            ]
        );
    }
}
