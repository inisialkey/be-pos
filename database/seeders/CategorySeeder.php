<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Category::factory(5)->create();
        \App\Models\Category::factory()->create([
            'name' => 'Foods Menu',
            'description' => 'Semua kategori makanan',
            'image' => 'random.png',
        ]);
        \App\Models\Category::factory()->create([
            'name' => 'Drinks Menu',
            'description' => 'Semua kategori minuman',
            'image' => 'random.png',
        ]);
    }
}
