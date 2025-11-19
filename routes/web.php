<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PemanduWisataController;
use App\Http\Controllers\Agent\AgentPackageController;
use App\Http\Controllers\Agent\AgentProfileController;
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\AppReviewController;

// Controller Pasar Digital dihapus (OlehOleh, Transport, Penginapan, Marketplace, AgentBusiness)

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

// ==== HALAMAN UTAMA ====
Route::get('/', function () {
    return view('welcome');
})->name('welcome'); 

Route::get('/tentang', function () {
    return view('tentang'); 
})->name('tentang');


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

    // --- DASHBOARD ---
    Route::get('/dashboard', [AgentDashboardController::class, 'index'])->name('dashboard');

    // --- PROFIL AGEN ---
    Route::get('/profile/create', [AgentProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [AgentProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile', [AgentProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AgentProfileController::class, 'update'])->name('profile.update');

    // --- PAKET TOUR (Hanya ini yang tersisa untuk Agent) ---
    Route::get('/packages', [AgentPackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/create', [AgentPackageController::class, 'create'])->name('packages.create');
    Route::post('/packages', [AgentPackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{tourPackage}/edit', [AgentPackageController::class, 'edit'])->name('packages.edit');
    Route::put('/packages/{tourPackage}', [AgentPackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{tourPackage}', [AgentPackageController::class, 'destroy'])->name('packages.destroy');
    
    // Rute Business/Pasar Digital dihapus
});

// Rute untuk menampilkan form registrasi agen
Route::get('/register/agent', [AuthController::class, 'showAgentRegisterForm'])->name('register.agent');
Route::post('/register/agent', [AuthController::class, 'registerAgent'])->name('register.agent.post');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role.admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('agents', [\App\Http\Controllers\Admin\AgentController::class, 'index'])->name('agents.index');
    Route::patch('agents/{agent}/approve', [\App\Http\Controllers\Admin\AgentController::class, 'approve'])->name('agents.approve');
    Route::patch('agents/{agent}/reject', [\App\Http\Controllers\Admin\AgentController::class, 'reject'])->name('agents.reject');
    Route::resource('agents', \App\Http\Controllers\Admin\AgentController::class)->except(['create', 'store']);
    Route::resource('destinations', \App\Http\Controllers\Admin\DestinationController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\DestinationCategoryController::class);

    Route::prefix('listings')->name('listings.')->group(function() {
        // Halaman Utama (Hanya menampilkan Tour)
        Route::get('/', [\App\Http\Controllers\Admin\AdminListingController::class, 'index'])->name('index');

        // --- ROUTE EDIT & UPDATE (Hanya Tour) ---
        Route::get('tours/{id}/edit', [\App\Http\Controllers\Admin\AdminListingController::class, 'editTour'])->name('tours.edit');
        Route::put('tours/{id}', [\App\Http\Controllers\Admin\AdminListingController::class, 'updateTour'])->name('tours.update');
        
        // Route Delete (Hapus Listing Tour)
        Route::delete('tours/{id}', [\App\Http\Controllers\Admin\AdminListingController::class, 'destroyTour'])->name('tours.destroy');
        
        // Rute edit/delete untuk penginapan, oleh-oleh, dll dihapus
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/ulasan-aplikasi', [AppReviewController::class, 'create'])->name('app-reviews.create');
    Route::post('/ulasan-aplikasi', [AppReviewController::class, 'store'])->name('app-reviews.store');
});