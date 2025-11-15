<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Ambil data user yang baru saja login
            $user = Auth::user();
            
            // Periksa role pengguna
            if ($user->role == 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            if ($user->role === 'agent') {
                
                // --- INI BAGIAN PENTING ---
                // Ambil profil agen dari user
                $agent = $user->agent;

                // Tentukan nama yang akan disapa
                // Jika profil agen sudah diisi, gunakan nama agensi ($agent->name)
                // Jika belum (masih null), gunakan nama lengkap user ($user->full_name)
                $agentName = $agent ? $agent->name : $user->full_name;
                
                // Arahkan ke dashboard agen dengan NAMA DINAMIS
                return redirect()->intended(route('agent.dashboard'))
                    ->with('success', 'Selamat datang kembali, ' . $agentName . '!');
            }

            // Untuk role 'user', arahkan ke beranda wisatawan
            return redirect()->intended(route('beranda.wisatawan'))
                ->with('success', 'Selamat datang kembali!');
        }

        return back()
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])
            ->withInput($request->only('email'));
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role untuk user baru
        ]);

        Auth::login($user);

        return redirect()->route('beranda.wisatawan')
            ->with('success', 'Registrasi berhasil! Selamat datang di PesibarSurf.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Show the agent registration form
     */
    public function showAgentRegisterForm()
    {
        return view('auth.register-agent'); // Ini sudah benar
    }

    /**
     * Handle agent registration request
     */
    public function registerAgent(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'agent', // Ini sudah benar
        ]);

        Auth::login($user);

        // Mengarahkan ke dashboard agen (ini sudah benar)
        return redirect()->route('agent.dashboard')
            ->with('success', 'Akun Anda berhasil dibuat! Selamat datang di PesibarSurf.');
    }
}