<?php

namespace App\Http\Controllers;

use App\Models\TransportDaerah;
use App\Models\TransportLuar;

class TransportController extends Controller
{
    // ================== TRANSPORTASI DAERAH ==================
    public function daerah()
    {
        $categories = [
            [
                'type'        => 'mobil',
                'title'       => 'Agen Sewa Mobil',
                'description' => 'Dapatkan jenis mobil yang kamu inginkan untuk berkeliling Pesibar.',
                'image'       => 'images/transport/mobil.png',
                'modal_id'    => 'modalDaerahMobil',
            ],
            [
                'type'        => 'motor',
                'title'       => 'Agen Sewa Motor',
                'description' => 'Pilihan motor untuk menjelajahi pantai dan desa wisata.',
                'image'       => 'images/transport/motor.png',
                'modal_id'    => 'modalDaerahMotor',
            ],
            [
                'type'        => 'penyeberangan',
                'title'       => 'Agen Penyeberangan Pulau',
                'description' => 'Layanan perahu dan penyeberangan ke pulau sekitar Pesibar.',
                'image'       => 'images/transport/perahu.png',
                'modal_id'    => 'modalDaerahPenyeberangan',
            ],
        ];

        $mobilAgents = TransportDaerah::where('type', 'mobil')->orderBy('id')->get();
        $motorAgents = TransportDaerah::where('type', 'motor')->orderBy('id')->get();
        $penyeberanganAgents = TransportDaerah::where('type', 'penyeberangan')->orderBy('id')->get();

        return view('wisatawan.pasarDigital.transport-daerah', compact(
            'categories',
            'mobilAgents',
            'motorAgents',
            'penyeberanganAgents'
        ));
    }

    // ================== TRANSPORTASI LUAR ==================
    public function luar()
    {
        // Kategori utama (Travel & Bus)
        $categories = [
            [
                'type'        => 'travel',
                'title'       => 'Agen Travel',
                'description' => 'Layanan travel untuk perjalanan luar daerah dari dan ke Pesibar.',
                'image'       => 'images/transport/travel.png',
                'modal_id'    => 'modalLuarTravel',
            ],
            [
                'type'        => 'bus',
                'title'       => 'Agen Pemesanan Bus',
                'description' => 'Layanan bus antar kota dan antar provinsi.',
                'image'       => 'images/transport/bus.png',
                'modal_id'    => 'modalLuarBus',
            ],
        ];

        // Ambil agen travel & bus dari DB
        $travelAgents = TransportLuar::where('type', 'travel')->orderBy('id')->get();
        $busAgents    = TransportLuar::where('type', 'bus')->orderBy('id')->get();

        return view('wisatawan.pasarDigital.transport-luar', compact(
            'categories',
            'travelAgents',
            'busAgents'
        ));
    }
}