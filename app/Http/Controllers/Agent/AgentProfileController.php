<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgentProfileController extends Controller
{
    public function create()
    {
        $agent = Auth::user()->agent;
        if ($agent) {
            return redirect()->route('agent.profile.edit');
        }
        return view('agent.profile.create', compact('agent'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        // Catatan: Input name di View tetap 'banner_image', 'file_ktp' (tanpa _url) agar rapi
        $request->validate([
            'phone_number' => 'required|string|max:20',
            'agent_type'   => 'required|string', // Kita ubah jadi string dulu agar menerima input baru
            'name'         => 'required|string|max:255',
            'address'      => 'required|string',
            'description'  => 'nullable|string',
            
            // Validasi file menggunakan nama input form (TANPA _url)
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_ktp'     => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'file_siup'    => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        // 2. Update User Phone
        $user = Auth::user();
        $user->phone_number = $request->phone_number;
        $user->save();

        // 3. Siapkan Data Agent
        // Kita buang field file input & phone_number dari array $data awal
        $data = $request->except(['banner_image', 'file_ktp', 'file_siup', 'phone_number']);
        
        $data['user_id'] = $user->id;
        $data['is_verified'] = false; // Sesuai schema default(false)

        // 4. Upload File Logic (MAPPING NAMA INPUT -> NAMA KOLOM DB)
        
        // A. Banner Image
        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('agent-documents', 'public');
            $data['banner_image_url'] = $path; 
        }

        // B. File KTP
        if ($request->hasFile('file_ktp')) {
            $path = $request->file('file_ktp')->store('agent-documents', 'public');
            $data['file_ktp_url'] = $path;
        }

        // C. File SIUP
        if ($request->hasFile('file_siup')) {
            $path = $request->file('file_siup')->store('agent-documents', 'public');
            $data['file_siup_url'] = $path;
        }

        Agent::create($data);

        return redirect()->route('agent.dashboard')->with('success', 'Profil agensi berhasil dikirim dan sedang ditinjau oleh Admin.');
    }

    public function edit()
    {
        $agent = Auth::user()->agent;
        if (!$agent) {
            return redirect()->route('agent.profile.create');
        }
        return view('agent.profile.edit', compact('agent'));
    }

    public function update(Request $request)
    {
        $agent = Auth::user()->agent;
        $user = Auth::user();

        if (!$agent) {
            return redirect()->route('agent.profile.create');
        }

        $request->validate([
            'phone_number'    => 'required|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            
            'agent_type'      => 'required|string',
            'name'            => 'required|string|max:255',
            'address'         => 'required|string',
            'description'     => 'nullable|string',
            
            'banner_image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_ktp'        => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'file_siup'       => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        // Update User Data
        $user->phone_number = $request->phone_number;
        
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture_url) {
                $oldPath = str_replace('/storage/', '', $user->profile_picture_url);
                $oldPath = str_replace(Storage::url(''), '', $user->profile_picture_url);
                if(Storage::disk('public')->exists($oldPath)) {
                     Storage::disk('public')->delete($oldPath);
                }
            }
            $path = $request->file('profile_picture')->store('profiles', 'public');
            $user->profile_picture_url = Storage::url($path);
        }
        $user->save();

        // Update Agent Data
        $agentData = $request->except([
            'phone_number', 'profile_picture', 'banner_image', 'file_ktp', 'file_siup', 
            '_token', '_method'
        ]);

        // Helper function upload (Updated for DB Schema)
        $uploadAndUpdate = function ($inputName, $dbColumn) use ($request, $agent, &$agentData) {
            if ($request->hasFile($inputName)) {
                // Hapus file lama jika ada
                if ($agent->$dbColumn) {
                     if(Storage::disk('public')->exists($agent->$dbColumn)) {
                        Storage::disk('public')->delete($agent->$dbColumn);
                     }
                }
                
                $path = $request->file($inputName)->store('agent-documents', 'public');
                // Simpan ke array data dengan key sesuai kolom DB
                $agentData[$dbColumn] = $path;
            }
        };

        // Panggil fungsi dengan pasangan (Nama Input, Nama Kolom DB)
        $uploadAndUpdate('banner_image', 'banner_image_url');
        $uploadAndUpdate('file_ktp', 'file_ktp_url');
        $uploadAndUpdate('file_siup', 'file_siup_url');

        $agent->update($agentData);

        return redirect()->route('agent.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}