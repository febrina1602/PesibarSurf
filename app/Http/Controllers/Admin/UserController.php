<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        // Ambil semua user (termasuk admin & agent), urutkan berdasarkan role, lalu paginasi
        $users = User::orderBy('role', 'asc')->orderBy('full_name', 'asc')->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,agent,admin',
        ]);

        User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(User $user)
    {
        // Menggunakan Route Model Binding untuk mengambil user
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Abaikan email user ini sendiri
            ],
            'phone_number' => 'nullable|string|max:20',
            'role' => 'required|in:user,agent,admin',
        ];

        // Jika admin mengisi password baru, validasi dan update
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        $data = $request->validate($rules);

        // Hash password baru jika ada
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Jika password tidak diisi, jangan update password
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        // Keamanan: Admin tidak bisa menghapus akunnya sendiri
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}