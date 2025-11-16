<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace-nya benar

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     */
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count(); 
        
        $totalAgents = Agent::count(); 
        
        $totalDestinations = Destination::count();
        
        $totalPackages = TourPackage::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAgents',
            'totalDestinations',
            'totalPackages'
        ));
    }
}