<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Validation\Rule; 

class AgentController extends Controller
{
    /**
     * Menampilkan daftar semua profil agen. (Sudah ada)
     */
    public function index()
    {
        $agents = Agent::with('user')
                        ->orderBy('is_verified', 'asc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
        
        return view('admin.agents.index', compact('agents'));
    }

    /**
     * Menampilkan halaman detail agen (untuk cek berkas).
     */
    public function show(Agent $agent)
    {
        // Eager load relasi user agar bisa tampilkan nama & no. telp
        $agent->load('user'); 
        return view('admin.agents.detail', compact('agent'));
    }

    /**
     * Menampilkan form edit agen.
     */
    public function edit(Agent $agent)
    {
        return view('admin.agents.edit', compact('agent'));
    }

    /**
     * Update data agen di database.
     */
    public function update(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'agent_type' => 'required|in:TOUR,RENTAL,BOTH',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $agent->update($data);

        return redirect()->route('admin.agents.index')->with('success', 'Data agen ' . $agent->name . ' berhasil diperbarui.');
    }

    /**
     * Hapus profil agen.
     */
    public function destroy(Agent $agent)
    {
        try {
            if ($agent->profile_image_path) {
                Storage::disk('public')->delete($agent->profile_image_path);
            }
            if ($agent->ktp_image_path) {
                Storage::disk('public')->delete($agent->ktp_image_path);
            }

            $agent->delete();
            
            return redirect()->route('admin.agents.index')->with('success', 'Profil agen ' . $agent->agency_name . ' telah dihapus.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus agen: ' . $e->getMessage());
        }
    }


    /**
     * Menyetujui (verifikasi) profil agen. 
     */
    public function approve(Agent $agent)
    {
        $agent->is_verified = true;
        $agent->save();

        return back()->with('success', 'Profil agen ' . $agent->agency_name . ' telah berhasil diverifikasi.');
    }

    /**
     * Menolak (membatalkan verifikasi) profil agen. 
     */
    public function reject(Agent $agent)
    {
        $agent->is_verified = false;
        $agent->save();

        return back()->with('success', 'Verifikasi untuk agen ' . $agent->agency_name . ' telah dibatalkan.');
    }
}