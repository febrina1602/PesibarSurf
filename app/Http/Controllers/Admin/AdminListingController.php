<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Import Model (Hanya TourPackage)
use App\Models\TourPackage;
// Model lain (Penginapan, OlehOleh, Transport) dihapus

class AdminListingController extends Controller
{
    public function index()
    {
        // Hanya mengambil data tours
        $tours = TourPackage::with('agent')->latest()->paginate(10, ['*'], 'tour_page');
        
        // Variabel lain dihapus dari compact. 
        // CATATAN: Pastikan view 'admin.listings.index' diperbarui agar tidak error memanggil variabel yang hilang.
        return view('admin.listings.index', compact('tours'));
    }

    // --- METHOD UNTUK TOUR PACKAGE ---

    public function destroyTour($id)
    {
        $data = TourPackage::findOrFail($id);
        if ($data->cover_image) Storage::disk('public')->delete($data->cover_image);
        $data->delete();
        return back()->with('success', 'Paket wisata berhasil dihapus.');
    }

    public function editTour($id) {
        $data = TourPackage::findOrFail($id);
        return view('admin.listings.edit', ['data' => $data, 'type' => 'tour', 'routeUpdate' => 'admin.listings.tours.update']);
    }

    public function updateTour(Request $request, $id) {
        $data = TourPackage::findOrFail($id);
        $request->validate([
            'name' => 'required|string',
            'price_per_person' => 'required|numeric',
            'duration' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $data->update($request->only(['name', 'price_per_person', 'duration', 'description']));
        return redirect()->route('admin.listings.index')->with('success', 'Paket Tour berhasil diperbarui.');
    }

    // Method untuk Penginapan, OlehOleh, dan Transport dihapus
}