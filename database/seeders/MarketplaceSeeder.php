<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marketplace;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        Marketplace::truncate(); // kosongkan dulu

        Marketplace::create([
            'image'       => 'images/transport/travel.png',
            'title'       => 'Transportasi',
            'description' => 'Dapatkan transportasi yang kamu inginkan',
            'slug'        => 'transportasi',
            'buttons'     => ['Transportasi Daerah', 'Transportasi Luar'],
        ]);

        Marketplace::create([
            'image'       => 'images/penginapan/penginapan.png',
            'title'       => 'Penginapan',
            'description' => 'Dapatkan penginapan yang nyaman',
            'slug'        => 'penginapan',
            'buttons'     => ['Pilih Penginapan'],
        ]);

        Marketplace::create([
            'image'       => 'images/oleh-oleh/oleh-oleh.png',
            'title'       => 'Oleh-oleh',
            'description' => 'Dapatkan oleh-oleh untuk kamu bawa pulang',
            'slug'        => 'oleh-oleh',
            'buttons'     => ['Pilih Oleh-oleh'],
        ]);
    }
}