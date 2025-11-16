<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\DestinationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DestinationController extends Controller
{
    /**
     * Helper function untuk mengurai Latitude dan Longitude dari URL Google Maps.
     */
    private function parseCoordinatesFromUrl(?string $url): ?array
    {
        if (!$url) {
            return null; // Kembalikan null jika URL kosong
        }
        
        $regex = '/@(-?\d+\.\d+),(-?\d+\.\d+)/';

        if (preg_match($regex, $url, $matches)) {
            return [
                'latitude' => (float) $matches[1],
                'longitude' => (float) $matches[2],
            ];
        }
        return null; // Kembalikan null jika pola tidak cocok
    }

    /**
     * Menampilkan daftar semua destinasi.
     */
    public function index()
    {
        $destinations = Destination::with('category')
                                ->orderBy('name', 'asc')
                                ->paginate(15);
        
        return view('admin.destinations.index', compact('destinations'));
    }

    /**
     * Menampilkan form untuk membuat destinasi baru.
     */
    public function create()
    {
        $categories = DestinationCategory::orderBy('name', 'asc')->get();
        return view('admin.destinations.create', compact('categories'));
    }

    /**
     * Menyimpan destinasi baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:destinations',
            'category_id' => 'required|exists:destination_categories,id', // <-- DIUBAH
            'address' => 'required|string',
            'maps_url' => 'nullable|url',
            'description' => 'required|string',
            'facilities' => 'nullable|string',
            'price_per_person' => 'required|numeric|min:0',
            'parking_price' => 'required|numeric|min:0',
            'popular_activities' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5',
            'is_featured' => 'nullable|boolean',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $coords = $this->parseCoordinatesFromUrl($request->maps_url);
        $data['latitude'] = $coords['latitude'] ?? null;
        $data['longitude'] = $coords['longitude'] ?? null;
        unset($data['maps_url']); 

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('destinations', 'public');
            $data['image_url'] = $path;
        }

        $data['is_featured'] = $request->has('is_featured');

        Destination::create($data);

        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit destinasi.
     */
    public function edit(Destination $destination)
    {
        $categories = DestinationCategory::orderBy('name', 'asc')->get();
        return view('admin.destinations.edit', compact('destination', 'categories'));
    }

    /**
     * Memperbarui data destinasi di database.
     */
    public function update(Request $request, Destination $destination)
    {
        $data = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('destinations')->ignore($destination->id),
            ],
            'category_id' => 'required|exists:destination_categories,id', // <-- DIUBAH
            'address' => 'required|string',
            'maps_url' => 'nullable|url',
            'description' => 'required|string',
            'facilities' => 'nullable|string',
            'price_per_person' => 'required|numeric|min:0',
            'parking_price' => 'required|numeric|min:0',
            'popular_activities' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5',
            'is_featured' => 'nullable|boolean',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->filled('maps_url')) {
            $coords = $this->parseCoordinatesFromUrl($request->maps_url);
            $data['latitude'] = $coords['latitude'] ?? $destination->latitude;
            $data['longitude'] = $coords['longitude'] ?? $destination->longitude;
        } else {
            $data['latitude'] = null;
            $data['longitude'] = null;
        }
        unset($data['maps_url']);

        if ($request->hasFile('image_url')) {
            if ($destination->image_url) {
                Storage::disk('public')->delete($destination->image_url);
            }
            $path = $request->file('image_url')->store('destinations', 'public');
            $data['image_url'] = $path;
        }

        $data['is_featured'] = $request->has('is_featured');

        $destination->update($data);

        return redirect()->route('admin.destinations.index')->with('success', 'Data destinasi berhasil diperbarui.');
    }

    /**
     * Menghapus destinasi dari database.
     */
    public function destroy(Destination $destination)
    {
        try {
            if ($destination->image_url) {
                Storage::disk('public')->delete($destination->image_url);
            }
            $destination->delete();
            return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus destinasi: ' . $e->getMessage());
        }
    }
}