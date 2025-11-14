<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('agent.packages.index', compact('tourPackages'));
    }

    // Menampilkan form tambah paket
    public function create()
    {
        return view('agent.packages.create');
    }

    // Menyimpan paket baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_person' => 'required|numeric|min:0',
            'duration' => 'nullable|string',
            // ... validasi lainnya sesuai Model TourPackage ...
        ]);

        $agent = Auth::user()->agent;

        $package = new TourPackage($request->all());
        // $package->agent_id = $agent->id; // Cara 1
        // $package->save();

        // Cara 2 (Lebih Eloquent)
        $agent->tourPackages()->create($request->all());

        return redirect()->route('agent.packages.index')->with('success', 'Paket baru berhasil ditambahkan.');
    }

    // ... (buat method edit, update, destroy) ...

    // PENTING: Untuk edit/update/destroy, pastikan agen hanya bisa mengubah paket miliknya sendiri!
    public function edit(TourPackage $tourPackage)
    {
        if ($tourPackage->agent_id !== Auth::user()->agent->id) {
            abort(403); // Tidak diizinkan
        }
        return view('agent.packages.edit', compact('tourPackage'));
    }
}