<?php

use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\AgentPackageController;
use App\Http\Controllers\Agent\AgentProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PemanduWisataController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\OlehOlehController;
use App\Http\Controllers\PenginapanController;


// ==== AUTHENTICATION ROUTES ====
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// // ==== HALAMAN UTAMA ====
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/beranda', function () {
    return view('wisatawan.beranda');
});


// ==== BERANDA & DESTINASI & PEMANDU WISATA (ROUTE WISATAWAN) ====
Route::get('/beranda', [BerandaController::class, 'wisatawan'])->name('beranda.wisatawan');

Route::get('/category/{id}', [DestinationController::class, 'byCategory'])
    ->name('destinations.category');

Route::get('/destination/{id}', [DestinationController::class, 'show'])
    ->name('destinations.detail');

Route::get('/pemandu-wisata', [PemanduWisataController::class, 'index'])->name('pemandu-wisata.index');
Route::get('/pemandu-wisata/{agent}', [PemanduWisataController::class, 'show'])->name('pemandu-wisata.show');
Route::get('/pemandu-wisata/{agent}/paket', [PemanduWisataController::class, 'packages'])->name('pemandu-wisata.packages');
Route::get('/pemandu-wisata/{agent}/paket/{tourPackage}', [PemanduWisataController::class, 'packageDetail'])->name('pemandu-wisata.package-detail');

/*
|--------------------------------------------------------------------------
| USER (WISATAWAN) PROFILE ROUTES
|--------------------------------------------------------------------------
*/
// Rute ini hanya bisa diakses oleh user yang login dengan role 'user'
Route::middleware(['auth', 'role.user'])->prefix('profile')->name('profile.')->group(function () {

    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
    Route::get('/password', [ProfileController::class, 'showPasswordForm'])->name('password.show');
    Route::put('/password', [ProfileController::class, 'update'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| AGENT DASHBOARD ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role.agent'])->prefix('agent')->name('agent.')->group(function () {

    // --- PROFIL AGEN ---
    // (Penting: Redirect jika agen belum punya profil)
    Route::get('/dashboard', [AgentDashboardController::class, 'index'])->name('dashboard');

    // Mendaftarkan/Membuat Profil Agen (setelah registrasi user)
    Route::get('/profile/create', [AgentProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [AgentProfileController::class, 'store'])->name('profile.store');

    // Mengelola Profil Agen (Edit/Update)
    Route::get('/profile', [AgentProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AgentProfileController::class, 'update'])->name('profile.update');

    // --- PAKET TOUR ---
    // Mengelola Paket (CRUD)
    Route::get('/packages', [AgentPackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/create', [AgentPackageController::class, 'create'])->name('packages.create');
    Route::post('/packages', [AgentPackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{tourPackage}/edit', [AgentPackageController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{tourPackage}', [AgentPackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{tourPackage}', [AgentPackageController::class, 'destroy'])->name('packages.destroy');

    // Rute untuk mengelola rental (jika ada)
    // Route::resource('/vehicles', AgentVehicleController::class);

});

// Rute untuk menampilkan form registrasi agen
Route::get('/register/agent', [AuthController::class, 'showAgentRegisterForm'])->name('register.agent');
Route::post('/register/agent', [AuthController::class, 'registerAgent'])->name('register.agent.post');


// ==== MARKETPLACE ROUTES ====
Route::prefix('marketplace')->group(function () {
    // Halaman utama Pasar Digital
    Route::get('/', [MarketplaceController::class, 'index'])
        ->name('marketplace.index');

    // Halaman Transportasi Daerah (menu dalam)
    Route::get('/transportasi/daerah', [TransportController::class, 'daerah'])
        ->name('transport.daerah');

    Route::get('/transportasi/luar', [TransportController::class, 'luar'])
        ->name('transport.luar');

    // Penginapan
    Route::get('/penginapan', [PenginapanController::class, 'index'])
        ->name('penginapan.index');

    // Oleh-oleh
    Route::get('/oleh-oleh', [OlehOlehController::class, 'index'])
        ->name('oleh.index');

});

