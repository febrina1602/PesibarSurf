<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransportDaerah;
use App\Models\TransportLuar;

class TransportSeeder extends Seeder
{
    public function run(): void
    {
        // ================== TRANSPORTASI DAERAH ==================
        TransportDaerah::truncate();

        // (isi yang daerah sama persis seperti tadi, biarkan saja)
        TransportDaerah::create([
            'type'        => 'mobil',
            'name'        => 'Agen Sewa Mobil Krui Jaya',
            'image'       => 'images/transport/mobil.png',
            'location'    => 'Krui, Pesisir Barat',
            'rating'      => 4.8,
            'price_range' => 'Mulai Rp 350.000 / hari',
            'description' => 'Menyediakan berbagai pilihan mobil untuk keperluan wisata dan perjalanan dalam daerah Pesibar.',
            'whatsapp'    => '6281234567890',
        ]);

        TransportDaerah::create([
            'type'        => 'mobil',
            'name'        => 'Agen Sewa Mobil Samudra',
            'image'       => 'images/transport/mobil.png',
            'location'    => 'Pesisir Tengah, Pesisir Barat',
            'rating'      => 4.6,
            'price_range' => 'Mulai Rp 300.000 / hari',
            'description' => 'Layanan sewa mobil harian dengan sopir berpengalaman dan rute fleksibel.',
            'whatsapp'    => '6282234567891',
        ]);

        TransportDaerah::create([
            'type'        => 'motor',
            'name'        => 'Sewa Motor Pantai Krui',
            'image'       => 'images/transport/motor.png',
            'location'    => 'Krui, Pesisir Barat',
            'rating'      => 4.9,
            'price_range' => 'Mulai Rp 100.000 / hari',
            'description' => 'Cocok untuk keliling spot pantai dan surfing di sekitar Krui.',
            'whatsapp'    => '6283134567892',
        ]);

        TransportDaerah::create([
            'type'        => 'motor',
            'name'        => 'Agen Motor Jelajah Pesibar',
            'image'       => 'images/transport/motor.png',
            'location'    => 'Pesisir Selatan, Pesisir Barat',
            'rating'      => 4.7,
            'price_range' => 'Mulai Rp 90.000 / hari',
            'description' => 'Penyewaan motor untuk menjelajahi desa wisata dan pantai di Pesisir Barat.',
            'whatsapp'    => '6284134567893',
        ]);

        TransportDaerah::create([
            'type'        => 'penyeberangan',
            'name'        => 'Penyeberangan Pulau Pisang Lestari',
            'image'       => 'images/transport/perahu.png',
            'location'    => 'Dermaga Pulau Pisang',
            'rating'      => 4.9,
            'price_range' => 'Mulai Rp 50.000 / orang',
            'description' => 'Layanan penyeberangan ke Pulau Pisang dengan jadwal reguler dan private trip.',
            'whatsapp'    => '6285134567894',
        ]);

        TransportDaerah::create([
            'type'        => 'penyeberangan',
            'name'        => 'Jasa Perahu Wisata Bahari',
            'image'       => 'images/transport/perahu.png',
            'location'    => 'Pesisir Tengah, Pesisir Barat',
            'rating'      => 4.8,
            'price_range' => 'Mulai Rp 70.000 / orang',
            'description' => 'Trip perahu untuk eksplorasi pulau-pulau kecil di sekitar Pesisir Barat.',
            'whatsapp'    => '6286134567895',
        ]);

        // ================== TRANSPORTASI LUAR ==================
        TransportLuar::truncate();

        // Travel
        TransportLuar::create([
            'type'        => 'travel',
            'name'        => 'Agen Travel Pesibar Jaya',
            'image'       => 'images/transport/travel.png',
            'location'    => 'Pesibar - Bandar Lampung',
            'rating'      => 4.8,
            'price_range' => 'Mulai Rp 180.000 / orang',
            'description' => 'Layanan travel harian rute Pesibar - Bandar Lampung dengan armada nyaman dan AC.',
            'whatsapp'    => '6287234567890',
        ]);

        TransportLuar::create([
            'type'        => 'travel',
            'name'        => 'Travel Samudra Raya',
            'image'       => 'images/transport/travel.png',
            'location'    => 'Pesibar - Bandar Lampung',
            'rating'      => 4.7,
            'price_range' => 'Mulai Rp 170.000 / orang',
            'description' => 'Travel dengan jadwal fleksibel dan fasilitas antar-jemput di area tertentu.',
            'whatsapp'    => '6288234567891',
        ]);

        // Bus
        TransportLuar::create([
            'type'        => 'bus',
            'name'        => 'Agen Bus Krui Indah',
            'image'       => 'images/transport/bus.png',
            'location'    => 'Pesibar - Bandar Lampung - Jakarta',
            'rating'      => 4.6,
            'price_range' => 'Mulai Rp 250.000 / orang',
            'description' => 'Layanan bus malam dengan rute antar kota dan antar provinsi.',
            'whatsapp'    => '6289234567892',
        ]);

        TransportLuar::create([
            'type'        => 'bus',
            'name'        => 'Agen Bus Samudra Line',
            'image'       => 'images/transport/bus.png',
            'location'    => 'Pesibar - Bandar Lampung - Palembang',
            'rating'      => 4.5,
            'price_range' => 'Mulai Rp 230.000 / orang',
            'description' => 'Bus dengan fasilitas AC, reclining seat, dan bagasi luas untuk perjalanan jarak jauh.',
            'whatsapp'    => '6290234567893',
        ]);
    }
}