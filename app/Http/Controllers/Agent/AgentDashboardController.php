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
        // Eager load relasi 'user' agar data email/telepon tersedia
        $agent = Auth::user()->agent()->with('user')->first(); 

        if (!$agent) {
            return redirect()->route('agent.profile.create')
                ->with('info', 'Selamat datang! Harap lengkapi profil agensi Anda terlebih dahulu.');
        }

        // Ambil semua paket tour yang dimiliki oleh agen ini
        $tourPackages = $agent->tourPackages()->orderBy('created_at', 'desc')->get();

        // Kirim data agent dan tourPackages ke view
        return view('agent.dashboard', [
            'agent' => $agent,
            'tourPackages' => $tourPackages,
        ]);
    }
}