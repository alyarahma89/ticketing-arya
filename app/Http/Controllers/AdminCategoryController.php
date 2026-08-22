<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    // Menampilkan daftar kategori (Dengan Fitur Pencarian)
    public function index(Request $request)
    {
        // 1. Persiapkan query dasar
        $query = Category::query();

        // 2. Jika ada kata kunci pencarian, saring datanya
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. Eksekusi query (oldest agar yang pertama dibuat muncul paling atas)
        $categories = $query->oldest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        // Menambahkan validasi untuk input gambar
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|url', // Memastikan gambar berupa Link/URL
        ]);

        Category::create([
            'name' => strtoupper($request->name), // Memastikan nama kategori huruf besar semua
            'image' => $request->image,           // Menyimpan link gambar ke database
        ]);

        return redirect()->back()->with('success', 'Kategori baru dan gambarnya berhasil ditambahkan!');
    }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        // Menambahkan validasi untuk input gambar saat edit
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$id,
            'image' => 'nullable|url', // Memastikan gambar berupa Link/URL
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => strtoupper($request->name),
            'image' => $request->image, // Memperbarui link gambar di database
        ]);

        return redirect()->back()->with('success', 'Data kategori berhasil diperbarui!');
    }

    // Menghapus kategori
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Opsional: Cek apakah kategori sedang dipakai oleh event sebelum dihapus
        if ($category->events()->count() > 0) {
            return redirect()->back()->withErrors(['Kategori ini sedang digunakan oleh Event aktif dan tidak bisa dihapus.']);
        }

        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
