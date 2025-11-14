<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgentPackageController extends Controller
{
    // Menampilkan semua paket milik agen yang sedang login
    public function index()
    {
        $agent = Auth::user()->agent;
        if (!$agent) {
            return redirect()->route('agent.profile.create')->with('error', 'Anda harus melengkapi profil agensi terlebih dahulu.');
        }

        $tourPackages = $agent->tourPackages()->orderBy('created_at', 'desc')->get();
        
        return view('agent.packages.index', compact('tourPackages', 'agent')); 
    }

    // Menampilkan form tambah paket
    public function create()
    {
        $agent = Auth::user()->agent;
        
        if (!$agent || !$agent->is_verified) {
             return redirect()->route('agent.dashboard')->with('error', 'Profil Anda harus terverifikasi untuk menambah paket.');
        }
        
        return view('agent.packages.create', compact('agent'));
    }

    // Menyimpan paket baru
    public function store(Request $request)
    {
        $agent = Auth::user()->agent;

        if (!$agent || !$agent->is_verified) {
            return redirect()->route('agent.dashboard')->with('error', 'Profil Anda harus terverifikasi.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'price_per_person' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'facilities' => 'nullable|string',
            'destinations_visited' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('package-covers', 'public');
            $data['cover_image_url'] = Storage::url($path);
        }

        $agent->tourPackages()->create($data);

        return redirect()->route('agent.packages.index')->with('success', 'Paket baru berhasil ditambahkan.');
    }

    // Menampilkan form edit paket
    public function edit(TourPackage $tourPackage)
    {
        $agent = Auth::user()->agent; 

        if ($tourPackage->agent_id !== $agent->id) {
            abort(403); // Tidak diizinkan
        }
        
        return view('agent.packages.edit', compact('tourPackage', 'agent'));
    }
    
    // ======================================================
    // === METHOD BARU UNTUK UPDATE (PERBAIKAN ERROR ANDA) ===
    // ======================================================

    /**
     * Update paket tour yang sudah ada di database.
     */
    public function update(Request $request, TourPackage $tourPackage)
    {
        $agent = Auth::user()->agent;

        // Keamanan: Pastikan agen ini adalah pemilik paket
        if ($tourPackage->agent_id !== $agent->id) {
            abort(403, 'Anda tidak diizinkan mengubah paket ini.');
        }

        // Validasi (Mirip dengan store)
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:100',
            'price_per_person' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Opsional
            'facilities' => 'nullable|string',
            'destinations_visited' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $data = $request->except('cover_image');

        // Logika untuk upload/update gambar
        if ($request->hasFile('cover_image')) {
            // 1. Hapus gambar lama jika ada
            if ($tourPackage->cover_image_url) {
                $oldPath = str_replace(Storage::url(''), '', $tourPackage->cover_image_url);
                Storage::disk('public')->delete($oldPath);
            }

            // 2. Simpan gambar baru
            $path = $request->file('cover_image')->store('package-covers', 'public');
            $data['cover_image_url'] = Storage::url($path);
        }

        // Update data paket
        $tourPackage->update($data);

        return redirect()->route('agent.packages.index')->with('success', 'Paket berhasil diperbarui.');
    }

    // ======================================================
    // === METHOD BARU UNTUK HAPUS PAKET ===
    // ======================================================

    /**
     * Hapus paket tour dari database.
     */
    public function destroy(TourPackage $tourPackage)
    {
        $agent = Auth::user()->agent;

        // Keamanan: Pastikan agen ini adalah pemilik paket
        if ($tourPackage->agent_id !== $agent->id) {
            abort(403, 'Anda tidak diizinkan menghapus paket ini.');
        }

        // Hapus gambar cover dari storage
        if ($tourPackage->cover_image_url) {
            $oldPath = str_replace(Storage::url(''), '', $tourPackage->cover_image_url);
            Storage::disk('public')->delete($oldPath);
        }

        // Hapus data dari database
        $tourPackage->delete();

        return redirect()->route('agent.packages.index')->with('success', 'Paket berhasil dihapus.');
    }
}