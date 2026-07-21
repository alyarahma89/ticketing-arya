<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        // Menggunakan oldest() agar yang pertama dibuat muncul paling atas,
        // dan yang baru ditambahkan akan muncul di paling bawah.
        $categories = Category::oldest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => strtoupper($request->name) // Memastikan nama kategori huruf besar semua
        ]);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    // Memperbarui kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$id,
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => strtoupper($request->name)
        ]);

        return redirect()->back()->with('success', 'Nama kategori berhasil diubah!');
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
