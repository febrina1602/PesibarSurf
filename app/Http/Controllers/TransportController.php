<?php

namespace App\Http\Controllers;

use App\Models\Transport;

class TransportController extends Controller
{
    // ================== TRANSPORTASI DAERAH ==================
    public function daerah()
    {
        // 3 kartu utama di halaman Transportasi Daerah
        $items = [
            [
                'image'       => asset('images/transport/mobil.png'),
                'title'       => 'Agen Sewa Mobil',
                'description' => 'Dapatkan jenis mobil yang kamu inginkan',
                'button'      => 'Rincian',
            ],
            [
                'image'       => asset('images/transport/motor.png'),
                'title'       => 'Agen Sewa Motor',
                'description' => 'Dapatkan jenis motor yang kamu inginkan',
                'button'      => 'Rincian',
            ],
            [
                'image'       => asset('images/transport/perahu.png'),
                'title'       => 'Agen Penyeberangan Pulau',
                'description' => 'Dapatkan penyeberangan sesuai kebutuhan',
                'button'      => 'Rincian',
            ],
        ];

        // Data agen sewa mobil (DAERAH)
        $mobilAgents = [
            [
                'image' => asset('images/transport/mobil.png'),
                'name'  => 'Nama Agen A',
            ],
            [
                'image' => asset('images/transport/mobil.png'),
                'name'  => 'Nama Agen B',
            ],
            [
                'image' => asset('images/transport/mobil.png'),
                'name'  => 'Nama Agen C',
            ],
            [
                'image' => asset('images/transport/mobil.png'),
                'name'  => 'Nama Agen D',
            ],
            [
                'image' => asset('images/transport/mobil.png'),
                'name'  => 'Nama Agen E',
            ],
            [
                'image' => asset('images/transport/mobil.png'),
                'name'  => 'Nama Agen F',
            ],
        ];

        // Data agen sewa motor (DAERAH)
        $motorAgents = [
            [
                'image' => asset('images/transport/motor.png'),
                'name'  => 'Nama Agen Motor A',
            ],
            [
                'image' => asset('images/transport/motor.png'),
                'name'  => 'Nama Agen Motor B',
            ],
            [
                'image' => asset('images/transport/motor.png'),
                'name'  => 'Nama Agen Motor C',
            ],
            [
                'image' => asset('images/transport/motor.png'),
                'name'  => 'Nama Agen Motor D',
            ],
        ];

        // Data agen penyeberangan / perahu (DAERAH)
        $kapalAgents = [
            [
                'image' => asset('images/transport/perahu.png'),
                'name'  => 'Agen Penyeberangan A',
            ],
            [
                'image' => asset('images/transport/perahu.png'),
                'name'  => 'Agen Penyeberangan B',
            ],
            [
                'image' => asset('images/transport/perahu.png'),
                'name'  => 'Agen Penyeberangan C',
            ],
        ];

        return view('transport-daerah', compact(
            'items',
            'mobilAgents',
            'motorAgents',
            'kapalAgents'
        ));
    }

    // ================== TRANSPORTASI LUAR ==================
    public function luar()
    {
        // 3 kartu utama di halaman Transportasi Luar
        $items = [
            [
                'image'       => asset('images/transport/travel.png'),
                'title'       => 'Travel',
                'description' => 'Dapatkan layanan travel untuk perjalanan jarak jauh',
                'button'      => 'Rincian',
            ],
            [
                'image'       => asset('images/transport/bus.png'),
                'title'       => 'Bus',
                'description' => 'Dapatkan layanan bus untuk perjalanan antar kota',
                'button'      => 'Rincian',
            ],
        ];

        // Data agen sewa mobil (LUAR DAERAH)
        $mobilAgents = [
            [
                'image' => asset('images/transport/travel.png'),
                'name'  => 'Agen Travel A',
            ],
            [
                'image' => asset('images/transport/travel.png'),
                'name'  => 'Agen Travel B',
            ],
            [
                'image' => asset('images/transport/travel.png'),
                'name'  => 'Agen Travel C',
            ],
            [
                'image' => asset('images/transport/travel.png'),
                'name'  => 'Agen Travel D',
            ],
        ];

        // Data agen sewa motor (LUAR DAERAH)
        $motorAgents = [
            [
                'image' => asset('images/transport/bus.png'),
                'name'  => 'Agen Bus A',
            ],
            [
                'image' => asset('images/transport/bus.png'),
                'name'  => 'Agen Bus B',
            ],
            [
                'image' => asset('images/transport/bus.png'),
                'name'  => 'Agen Bus C',
            ],
        ];

        return view('transport-luar', compact(
            'items',
            'mobilAgents',
            'motorAgents'
        ));
    }
}
