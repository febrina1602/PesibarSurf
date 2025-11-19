<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Import Model
use App\Models\TourPackage;
use App\Models\Penginapan;
use App\Models\OlehOleh;
use App\Models\TransportDaerah;
use App\Models\TransportLuar;

class AdminListingController extends Controller
{
    public function index()
    {
        // Mengambil data dengan pagination yang berbeda nama parameternya
        $tours = TourPackage::with('agent')->latest()->paginate(10, ['*'], 'tour_page');
        $penginapan = Penginapan::with('agent')->latest()->paginate(10, ['*'], 'stay_page');
        $olehOleh = OlehOleh::with('agent')->latest()->paginate(10, ['*'], 'oleh_page');
        
        $transportDaerah = TransportDaerah::with('agent')->latest()->paginate(10, ['*'], 'trans_local_page');
        $transportLuar = TransportLuar::with('agent')->latest()->paginate(10, ['*'], 'trans_inter_page');

        return view('admin.listings.index', compact(
            'tours', 
            'penginapan', 
            'olehOleh', 
            'transportDaerah', 
            'transportLuar'
        ));
    }

    // --- METHOD HAPUS (DELETE) ---

    public function destroyTour($id)
    {
        $data = TourPackage::findOrFail($id);
        if ($data->cover_image) Storage::disk('public')->delete($data->cover_image);
        $data->delete();
        return back()->with('success', 'Paket wisata berhasil dihapus.');
    }

    public function destroyPenginapan($id)
    {
        $data = Penginapan::findOrFail($id);
        if ($data->image) Storage::disk('public')->delete($data->image);
        $data->delete();
        return back()->with('success', 'Data penginapan berhasil dihapus.');
    }

    public function destroyOlehOleh($id)
    {
        $data = OlehOleh::findOrFail($id);
        if ($data->image) Storage::disk('public')->delete($data->image);
        $data->delete();
        return back()->with('success', 'Data oleh-oleh berhasil dihapus.');
    }

    public function destroyTransportDaerah($id)
    {
        $data = TransportDaerah::findOrFail($id);
        if ($data->image) Storage::disk('public')->delete($data->image);
        $data->delete();
        return back()->with('success', 'Transport daerah berhasil dihapus.');
    }

    public function destroyTransportLuar($id)
    {
        $data = TransportLuar::findOrFail($id);
        if ($data->image) Storage::disk('public')->delete($data->image);
        $data->delete();
        return back()->with('success', 'Transport luar berhasil dihapus.');
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

    public function editPenginapan($id) {
        $data = Penginapan::findOrFail($id);
        return view('admin.listings.edit', ['data' => $data, 'type' => 'stay', 'routeUpdate' => 'admin.listings.penginapan.update']);
    }
    public function updatePenginapan(Request $request, $id) {
        $data = Penginapan::findOrFail($id);
        $request->validate(['name' => 'required', 'location' => 'required', 'price_start' => 'required']);
        $data->update($request->only(['name', 'location', 'price_start', 'description']));
        return redirect()->route('admin.listings.index')->with('success', 'Data Penginapan berhasil diperbarui.');
    }

    public function editOlehOleh($id) {
        $data = OlehOleh::findOrFail($id);
        return view('admin.listings.edit', ['data' => $data, 'type' => 'oleh', 'routeUpdate' => 'admin.listings.oleh-oleh.update']);
    }
    public function updateOlehOleh(Request $request, $id) {
        $data = OlehOleh::findOrFail($id);
        $request->validate(['name' => 'required', 'location' => 'required', 'price_range' => 'required']);
        $data->update($request->only(['name', 'location', 'price_range', 'description']));
        return redirect()->route('admin.listings.index')->with('success', 'Data Oleh-oleh berhasil diperbarui.');
    }

    public function editTransportDaerah($id) {
        $data = TransportDaerah::findOrFail($id);
        return view('admin.listings.edit', ['data' => $data, 'type' => 'trans_local', 'routeUpdate' => 'admin.listings.transport-daerah.update']);
    }
    public function updateTransportDaerah(Request $request, $id) {
        $data = TransportDaerah::findOrFail($id);
        $request->validate(['name' => 'required', 'price_range' => 'required']);
        $data->update($request->only(['name', 'price_range', 'description']));
        return redirect()->route('admin.listings.index')->with('success', 'Data Transport Daerah berhasil diperbarui.');
    }

    public function editTransportLuar($id) {
        $data = TransportLuar::findOrFail($id);
        return view('admin.listings.edit', ['data' => $data, 'type' => 'trans_inter', 'routeUpdate' => 'admin.listings.transport-luar.update']);
    }
    public function updateTransportLuar(Request $request, $id) {
        $data = TransportLuar::findOrFail($id);
        $request->validate(['name' => 'required', 'location' => 'required']); // Location disini = Rute
        $data->update($request->only(['name', 'location', 'description']));
        return redirect()->route('admin.listings.index')->with('success', 'Data Transport Luar berhasil diperbarui.');
    }
}