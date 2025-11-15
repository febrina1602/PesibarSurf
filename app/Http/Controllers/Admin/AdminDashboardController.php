<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace-nya benar

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     */
    public function index() // Pastikan method 'index' ini ada
    {
        // Dan pastikan me-return view 'admin.dashboard'
        return view('admin.dashboard');
    }
}