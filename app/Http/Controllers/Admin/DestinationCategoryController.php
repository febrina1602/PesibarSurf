<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DestinationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DestinationCategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     */
    public function index()
    {
        $categories = DestinationCategory::withCount('destinations') 
                                        ->orderBy('name', 'asc')
                                        ->paginate(15);
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:destination_categories',
            'icon_url' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('icon_url')) {
            $path = $request->file('icon_url')->store('categories', 'public');
            $data['icon_url'] = $path;
        }

        DestinationCategory::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     */
    public function edit(DestinationCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori di database.
     */
    public function update(Request $request, DestinationCategory $category)
    {
        $data = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('destination_categories')->ignore($category->id),
            ],
            'icon_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('icon_url')) {
            if ($category->icon_url) {
                Storage::disk('public')->delete($category->icon_url);
            }
            $path = $request->file('icon_url')->store('categories', 'public');
            $data['icon_url'] = $path;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Data kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function destroy(DestinationCategory $category)
    {
        try {
            // Cek jika kategori masih digunakan oleh destinasi
            if ($category->destinations()->count() > 0) {
                return back()->with('error', 'Kategori "'. $category->name .'" tidak dapat dihapus karena masih digunakan oleh destinasi.');
            }

            if ($category->icon_url) {
                Storage::disk('public')->delete($category->icon_url);
            }
            
            $category->delete();

            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
        
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}