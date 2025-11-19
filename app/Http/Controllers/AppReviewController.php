<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppReview;
use Illuminate\Support\Facades\Auth;

class AppReviewController extends Controller
{
    public function create()
    {
        // Gunakan view yang sama (create-app.blade.php)
        return view('wisatawan.reviews.create-app');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5',
            'photos.*' => 'image|max:2048' // Jika ada upload foto
        ]);

        // Simpan ke database
        AppReview::create([
            'user_id' => Auth::id(), // Ini otomatis menyimpan ID user (baik agent maupun wisatawan)
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);
        
        // LOGIKA REDIRECT BERDASARKAN ROLE
        $user = Auth::user();
        $message = 'Terima kasih! Ulasan aplikasi Anda berhasil dikirim.';

        if ($user->role == 'agent') {
            return redirect()->route('agent.dashboard')->with('success', $message);
        } else {
            return redirect()->route('beranda.wisatawan')->with('success', $message);
        }
    }
}