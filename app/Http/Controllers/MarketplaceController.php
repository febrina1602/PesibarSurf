<?php

namespace App\Http\Controllers;

use App\Models\Marketplace;

class MarketplaceController extends Controller
{
    public function index()
    {
        // Ambil semua kategori dari database
        $categories = Marketplace::orderBy('id')->get();

        return view('marketplace', compact('categories'));
    }
}