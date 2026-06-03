<?php

namespace Database\Seeders;

use App\Models\CarouselItem;
use Illuminate\Database\Seeder;

class CarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarouselItem::create([
            'image_path' => '/images/studio_room_1.png',
            'title' => 'Studio Grande',
            'description' => 'Studio besar untuk band 5-8 personil dengan peralatan panggung premium, marshall amp, pearl acoustic drums, dan monitoring gila-gilaan.',
        ]);

        CarouselItem::create([
            'image_path' => '/images/studio_room_2.png',
            'title' => 'Studio Deluxe',
            'description' => 'Sangat cocok untuk latihan rutin band beranggotakan 3-5 personil dengan gear berkualitas tinggi, fender amp, dan akustik kedap suara.',
        ]);

        CarouselItem::create([
            'image_path' => '/images/studio_room_3.png',
            'title' => 'Analog Session Room',
            'description' => 'Sesi rekaman penuh 1 hari lengkap dengan sound engineer professional, multitrack mixing console, dan microphone studio kelas premium.',
        ]);
    }
}
