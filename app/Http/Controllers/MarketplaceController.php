<?php

namespace App\Http\Controllers;

use App\Models\Marketplace;

class MarketplaceController extends Controller
{
    public function index()
    {
        // Sementara data statis (bisa diganti ambil dari DB kalau mau)
        $categories = [
            [
                'icon'        => '🌊',
                'title'       => 'Transportasi',
                'description' => 'Dapatkan transportasi yang kamu inginkan',
                'buttons'     => ['Transportasi Daerah', 'Transportasi Luar'],
                'slug'        => 'transportasi',
            ],
            [
                'icon'        => '🏨',
                'title'       => 'Penginapan',
                'description' => 'Dapatkan penginapan yang nyaman',
                'buttons'     => ['Pilih Penginapan'],
                'slug'        => 'penginapan',
            ],
            [
                'icon'        => '🛍️',
                'title'       => 'Oleh-oleh',
                'description' => 'Dapatkan oleh-oleh untuk kamu bawa pulang',
                'buttons'     => ['Pilih Oleh-oleh'],
                'slug'        => 'oleh-oleh',
            ],
        ];

        return view('marketplace', compact('categories'));
    }
}
