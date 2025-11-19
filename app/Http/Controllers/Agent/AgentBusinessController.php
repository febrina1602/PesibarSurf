<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Penginapan;
use App\Models\OlehOleh;
use App\Models\TransportDaerah;
use App\Models\TransportLuar;
use Illuminate\Support\Str;

class AgentBusinessController extends Controller
{
    // Helper: Tentukan Model berdasarkan Tipe Agent
    private function getModelClass($type)
    {
        if ($type == 'PENGINAPAN') return Penginapan::class;
        if ($type == 'OLEH_OLEH') return OlehOleh::class;
        if (in_array($type, ['RENTAL', 'BOTH'])) return TransportDaerah::class;
        if (in_array($type, ['TRAVEL', 'BUS'])) return TransportLuar::class;
        return null;
    }

    public function index()
    {
        $agent = Auth::user()->agent;
        if (!$agent) return redirect()->route('agent.dashboard');

        if ($agent->agent_type == 'TOUR') {
            return redirect()->route('agent.dashboard')->with('error', 'Fitur tidak tersedia.');
        }

        $modelClass = $this->getModelClass($agent->agent_type);
        
        // AMBIL SEMUA DATA (get), BUKAN CUMA SATU
        $businesses = $modelClass ? $modelClass::where('agent_id', $agent->id)->get() : collect();

        return view('agent.business.index', compact('agent', 'businesses'));
    }

    public function create()
    {
        $agent = Auth::user()->agent;
        return view('agent.business.form', compact('agent'))->with('data', null); // Form Kosong
    }

    public function store(Request $request)
    {
        $agent = Auth::user()->agent;
        $this->saveData($request, $agent); // Panggil fungsi simpan
        return redirect()->route('agent.business.index')->with('success', 'Usaha baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $agent = Auth::user()->agent;
        $modelClass = $this->getModelClass($agent->agent_type);
        
        // Cari data spesifik milik agent ini
        $data = $modelClass::where('agent_id', $agent->id)->findOrFail($id);

        return view('agent.business.form', compact('agent', 'data')); // Form Terisi
    }

    public function update(Request $request, $id)
    {
        $agent = Auth::user()->agent;
        $this->saveData($request, $agent, $id); // Panggil fungsi simpan dengan ID
        return redirect()->route('agent.business.index')->with('success', 'Data usaha berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $agent = Auth::user()->agent;
        $modelClass = $this->getModelClass($agent->agent_type);
        
        $business = $modelClass::where('agent_id', $agent->id)->findOrFail($id);
        
        if ($business->image && Storage::disk('public')->exists($business->image)) {
            Storage::disk('public')->delete($business->image);
        }
        $business->delete();

        return redirect()->route('agent.business.index')->with('success', 'Data usaha berhasil dihapus.');
    }

    // --- LOGIKA PENYIMPANAN (DRY - Don't Repeat Yourself) ---
    private function saveData($request, $agent, $id = null)
    {
        $modelClass = $this->getModelClass($agent->agent_type);
        
        // Jika ID ada (Update), cari data. Jika tidak (Create), buat baru.
        $business = $id ? $modelClass::where('agent_id', $agent->id)->findOrFail($id) : new $modelClass();

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'whatsapp' => 'required|string|max:20',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $business->agent_id = $agent->id;
        $business->name = $request->name;
        $business->location = $request->location;
        $business->description = $request->description;
        $business->whatsapp = $request->whatsapp;
        $business->rating = $request->rating;

        // Data Khusus
        if ($agent->agent_type == 'PENGINAPAN') {
            $business->price_start = $request->price_start;
        } else {
            $business->price_range = $request->price_range;
        }
        
        if (in_array($agent->agent_type, ['RENTAL', 'BOTH', 'TRAVEL', 'BUS'])) {
             $business->type = $request->type;
        }

        // Upload Gambar
        if ($request->hasFile('image')) {
            if ($business->image && Storage::disk('public')->exists($business->image)) {
                Storage::disk('public')->delete($business->image);
            }
            $business->image = $request->file('image')->store('business-images', 'public');
        }

        $business->save();
    }
}