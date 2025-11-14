<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\DestinationCategory;
use App\Models\RentalVehicle;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function wisatawan()
    {
        $categories = DestinationCategory::all();

        // Destinasi unggulan
        $recommendations = Destination::where('is_featured', true)
            ->orderBy('rating', 'desc')
            ->take(6)
            ->get();

        // Paket wisata populer
        $tourPackages = TourPackage::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Kendaraan sewa terbaru
        $rentalVehicles = RentalVehicle::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('wisatawan.beranda', compact( 
            'categories',
            'recommendations',
            'tourPackages',
            'rentalVehicles'
        ));
    }
}
