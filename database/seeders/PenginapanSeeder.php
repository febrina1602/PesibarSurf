<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penginapan;

class PenginapanSeeder extends Seeder
{
    public function run(): void
    {
        Penginapan::truncate();

        Penginapan::create([
            'name'        => 'Penginapan Krui Beachfront',
            'image'       => 'images/penginapan/krui-beachfront.png',
            'location'    => 'Krui, Pesisir Barat',
            'rating'      => 4.8,
            'price_start' => 'Rp 350.000 / malam',
            'description' => 'Penginapan tepi pantai dengan akses langsung ke spot surfing dan fasilitas kamar yang nyaman.',
            'whatsapp'    => '6281234567890',
        ]);

        Penginapan::create([
            'name'        => 'Homestay Pesisir Nyaman',
            'image'       => 'images/penginapan/homestay-nyaman.png',
            'location'    => 'Pesisir Tengah, Pesisir Barat',
            'rating'      => 4.5,
            'price_start' => 'Rp 250.000 / malam',
            'description' => 'Homestay dengan suasana kekeluargaan, cocok untuk backpacker dan keluarga kecil.',
            'whatsapp'    => '6282234567890',
        ]);

        Penginapan::create([
            'name'        => 'Villa Bukit Samudra',
            'image'       => 'images/penginapan/villa-bukit.png',
            'location'    => 'Pesisir Selatan, Pesisir Barat',
            'rating'      => 4.9,
            'price_start' => 'Rp 550.000 / malam',
            'description' => 'Villa dengan pemandangan laut dari ketinggian, cocok untuk rombongan dan staycation.',
            'whatsapp'    => '6283134567890',
        ]);
    }
}