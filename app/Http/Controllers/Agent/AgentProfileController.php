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
        $agent = Auth::user()->agent; // <-- 1. Ambil data agent (meskipun null)
        if ($agent) {
            return redirect()->route('agent.profile.edit');
        }
        return view('agent.profile.create', compact('agent')); // <-- 2. Kirim ke view
    }

    public function store(Request $request)
    {
        // ... Kode store Anda sudah benar ...
        $request->validate([
            'agent_type' => 'required|in:TOUR,RENTAL,BOTH',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_ktp' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048', 
            'file_siup' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048', 
        ]);
        $data = $request->except(['banner_image', 'file_ktp', 'file_siup']);
        $data['user_id'] = Auth::id();
        $data['is_verified'] = false;
        $uploadFile = function ($fileKey) use ($request, &$data) {
            if ($request->hasFile($fileKey)) {
                $path = $request->file($fileKey)->store('agent-documents', 'public');
                $data[$fileKey . '_url'] = $path;
            }
        };
        $uploadFile('banner_image');
        $uploadFile('file_ktp');
        $uploadFile('file_siup');
        Agent::create($data);
        return redirect()->route('agent.dashboard')->with('success', 'Profil agensi berhasil dikirim dan sedang ditinjau oleh Admin.');
    }

    public function edit()
    {
        $agent = Auth::user()->agent;
        if (!$agent) {
            return redirect()->route('agent.profile.create');
        }
        // Kode Anda sudah benar mengirim 'agent'
        return view('agent.profile.edit', compact('agent'));
    }

    public function update(Request $request)
    {
        // ... Kode update Anda sudah benar ...
        $agent = Auth::user()->agent;
        $user = Auth::user(); 
        if (!$agent) {
            return redirect()->route('agent.profile.create');
        }
        $request->validate([
            'phone_number' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'agent_type' => 'required|in:TOUR,RENTAL,BOTH',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_ktp' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'file_siup' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);
        $user->phone_number = $request->phone_number;
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture_url) {
                $oldPath = str_replace(Storage::url(''), '', $user->profile_picture_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('profile_picture')->store('profiles', 'public');
            $user->profile_picture_url = Storage::url($path);
        }
        $user->save();
        $agentData = $request->except([
            'phone_number', 'profile_picture', 'banner_image', 'file_ktp', 'file_siup', 
            '_token', '_method'
        ]);
        $uploadFile = function ($fileKey) use ($request, $agent, &$agentData) {
            if ($request->hasFile($fileKey)) {
                $urlKey = $fileKey . '_url';
                if ($agent->$urlKey) {
                    $oldPath = str_replace(Storage::url(''), '', $agent->$urlKey);
                    Storage::disk('public')->delete($oldPath);
                }
                $path = $request->file($fileKey)->store('agent-documents', 'public');
                $agentData[$urlKey] = $path;
            }
        };
        $uploadFile('banner_image');
        $uploadFile('file_ktp');
        $uploadFile('file_siup');
        $agent->update($agentData);
        return redirect()->route('agent.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}