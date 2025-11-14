<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Mengarahkan ke halaman edit profil
    public function show()
    {
        $user = Auth::user();
        return view('wisatawan.profile.edit', compact('user'));
    }

    // Menampilkan form ganti password
    public function showPasswordForm()
    {
        $user = Auth::user();
        return view('wisatawan.profile.password', compact('user'));
    }

    /**
     * Update data profil ATAU password.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // JIKA INI ADALAH UPDATE PASSWORD
        if ($request->has('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', Password::min(8)],
            ]);

            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('profile.password.show')->with('success', 'Password berhasil diperbarui!');
        }

        // JIKA INI ADALAH UPDATE PROFIL BIASA
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => [ 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id), ],
            'phone_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->fill($request->only('full_name', 'email', 'phone_number', 'gender'));
        
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture_url) {
                $oldPath = str_replace(Storage::url(''), '', $user->profile_picture_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('profile_picture')->store('profiles', 'public');
            $user->profile_picture_url = Storage::url($path);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}