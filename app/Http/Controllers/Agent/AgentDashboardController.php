<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller; // <-- PENTING: Gunakan base controller
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- PENTING: Untuk mengambil data user

class AgentDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama untuk agen.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 1. Ambil relasi 'agent' dari user yang sedang login.
        //    Variabel $agent akan berisi data agensi ATAU null jika belum dibuat.
        $agent = Auth::user()->agent;

        // 2. HAPUS LOGIKA REDIRECT LAMA
        //    Sekarang kita langsung tampilkan view dashboard.
        //    View-nya yang akan kita buat pintar untuk menangani jika $agent null.
        return view('agent.dashboard', [
            'agent' => $agent,
        ]);
    }
}