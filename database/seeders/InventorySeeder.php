<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Drinks
        Inventory::create([
            'type' => 'drink',
            'name' => 'Air Mineral',
            'stock_qty' => 50,
            'price' => 5000.00,
            'condition' => null,
        ]);

        Inventory::create([
            'type' => 'drink',
            'name' => 'Coca Cola',
            'stock_qty' => 30,
            'price' => 8000.00,
            'condition' => null,
        ]);

        Inventory::create([
            'type' => 'drink',
            'name' => 'Pocari Sweat',
            'stock_qty' => 25,
            'price' => 10000.00,
            'condition' => null,
        ]);

        Inventory::create([
            'type' => 'drink',
            'name' => 'Teh Botol Sosro',
            'stock_qty' => 40,
            'price' => 6000.00,
            'condition' => null,
        ]);

        // Equipment
        Inventory::create([
            'type' => 'equipment',
            'name' => 'Kabel Jack Fender 3m',
            'stock_qty' => 10,
            'price' => null,
            'condition' => 'Baik',
        ]);

        Inventory::create([
            'type' => 'equipment',
            'name' => 'Gitar Listrik Yamaha Pacifica',
            'stock_qty' => 2,
            'price' => null,
            'condition' => 'Baik',
        ]);

        Inventory::create([
            'type' => 'equipment',
            'name' => 'Amplifier Marshall MG15',
            'stock_qty' => 2,
            'price' => null,
            'condition' => 'Sedang Diperbaiki',
        ]);

        Inventory::create([
            'type' => 'equipment',
            'name' => 'Set Cymbal Drum Sabian',
            'stock_qty' => 1,
            'price' => null,
            'condition' => 'Baik',
        ]);

        Inventory::create([
            'type' => 'equipment',
            'name' => 'Microphone Shure SM58',
            'stock_qty' => 4,
            'price' => null,
            'condition' => 'Baik',
        ]);

        Inventory::create([
            'type' => 'equipment',
            'name' => 'Kabel Jack Canare 5m',
            'stock_qty' => 5,
            'price' => null,
            'condition' => 'Rusak',
        ]);
    }
}
