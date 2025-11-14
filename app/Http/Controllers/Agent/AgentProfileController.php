<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentProfileController extends Controller
{
    // Menampilkan form pembuatan profil agensi
    public function create()
    {
        // Cek jika agen sudah punya profil, redirect ke edit
        if (Auth::user()->agent) {
            return redirect()->route('agent.profile.edit');
        }
        return view('agent.profile.create');
    }

    // Menyimpan profil agensi baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'description' => 'nullable|string',
            'banner_image_url' => 'nullable|string|max:255', // (Anda mungkin ingin validasi URL atau File Upload)
        ]);

        $agent = new Agent($request->all());
        $agent->user_id = Auth::id();
        $agent->is_verified = false; // Perlu verifikasi admin
        $agent->save();

        return redirect()->route('agent.dashboard')->with('success', 'Profil agensi berhasil disimpan.');
    }

    // Menampilkan form edit profil agensi
    public function edit()
    {
        $agent = Auth::user()->agent;
        // Jika belum punya profil, paksa buat
        if (!$agent) {
            return redirect()->route('agent.profile.create');
        }
        return view('agent.profile.edit', compact('agent'));
    }

    // ... (buat method update() untuk menyimpan perubahan) ...
}