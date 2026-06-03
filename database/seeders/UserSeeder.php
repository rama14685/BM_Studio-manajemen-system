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
            'shift_start' => '08:00:00',
            'shift_end' => '23:00:00',
            'face_features' => json_encode(array_fill(0, 128, 0.1)),
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
