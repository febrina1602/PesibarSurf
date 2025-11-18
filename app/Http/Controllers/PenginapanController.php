<?php

namespace App\Http\Controllers;

use App\Models\Penginapan;

class PenginapanController extends Controller
{
    public function index()
    {
        // Ambil semua penginapan dari DB
        $penginapans = Penginapan::orderBy('id')->get();

        return view('penginapan', compact('penginapan'));
    }
}