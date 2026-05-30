<?php

namespace Database\Seeders;

use App\Models\Studio;
use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Studio::create([
            'name' => 'Studio Kecil',
            'description' => 'Studio berukuran sedang, cocok untuk latihan band kecil (3-5 personil). Dilengkapi dengan drum standar, 2 gitar amp, 1 bass amp, dan vocal mic.',
            'price_per_hour' => 50000.00,
        ]);

        Studio::create([
            'name' => 'Studio Besar',
            'description' => 'Studio berukuran luas, ideal untuk band besar (5-8 personil) atau sesi recording/live. Dilengkapi drum premium, gitar amp Marshall, bass amp Ampeg, keyboard, dan vocal mic berkualitas tinggi.',
            'price_per_hour' => 80000.00,
        ]);
    }
}
