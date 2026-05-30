<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin BM Studio',
            'email' => 'admin@bmstudio.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '08123456789',
        ]);

        User::create([
            'name' => 'Pelanggan BM Studio',
            'email' => 'user@bmstudio.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'phone' => '08987654321',
        ]);
    }
}
