<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OlehOleh;

class OlehOlehSeeder extends Seeder
{
    public function run(): void
    {
        OlehOleh::truncate();

        OlehOleh::create([
            'name'        => 'Toko Oleh-oleh Krui Makmur',
            'image'       => 'images/oleh-oleh/krui-makmur.png',
            'location'    => 'Krui, Pesisir Barat',
            'rating'      => 4.7,
            'price_range' => 'Mulai Rp 20.000',
            'description' => 'Menyediakan kopi robusta Lampung, keripik pisang, dan aneka camilan khas Pesisir Barat.',
            'whatsapp'    => '628123450001',
        ]);

        OlehOleh::create([
            'name'        => 'Pusat Oleh-oleh Samudra Rasa',
            'image'       => 'images/oleh-oleh/samudra-rasa.png',
            'location'    => 'Pesisir Tengah, Pesisir Barat',
            'rating'      => 4.8,
            'price_range' => 'Mulai Rp 15.000',
            'description' => 'Toko oleh-oleh dengan berbagai pilihan makanan kering, sambal khas, dan souvenir pantai.',
            'whatsapp'    => '628223450002',
        ]);

        OlehOleh::create([
            'name'        => 'Galeri Khas Pesisir',
            'image'       => 'images/oleh-oleh/galeri-khas.png',
            'location'    => 'Pesisir Selatan, Pesisir Barat',
            'rating'      => 4.9,
            'price_range' => 'Mulai Rp 30.000',
            'description' => 'Menjual kerajinan tangan lokal, kaos khas Krui, dan aksesoris pantai untuk buah tangan.',
            'whatsapp'    => '628313450003',
        ]);
    }
}