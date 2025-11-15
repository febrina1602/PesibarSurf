<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DestinationCategory;

class DestinationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DestinationCategory::updateOrCreate(
            ['name' => 'Pantai'],
            ['icon_url' => 'images/pantai.png'] 
        );
        
        DestinationCategory::updateOrCreate(
            ['name' => 'Gunung'],
            ['icon_url' => 'images/gunung.png']
        );
        
        DestinationCategory::updateOrCreate(
            ['name' => 'Air Terjun'],
            ['icon_url' => 'images/arter.png']
        );
        
        DestinationCategory::updateOrCreate(
            ['name' => 'Kuliner'],
            ['icon_url' => 'images/kuliner.png']
        );
        
        DestinationCategory::updateOrCreate(
            ['name' => 'Budaya'],
            ['icon_url' => 'images/budaya.png']
        );
    }
}