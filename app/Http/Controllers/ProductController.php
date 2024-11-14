<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index(): View
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    // Menampilkan form untuk membuat produk baru
    public function create(): View
    {
        return view('products.create');
    }

    // Menyimpan data produk baru
    public function store(Request $request): RedirectResponse
    {
        // Validasi form
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required|min:5',
            'size' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required|min:10',
        ]);

        // Buat custom ID berdasarkan huruf depan produk dan random string
        $firstLetter = strtoupper(substr($request->title, 0, 1));
        $custom_id = $firstLetter;


        // Upload dan simpan gambar
        $image = $request->file('image');
        $imageName = $image->hashName(); // Gunakan hash name agar tidak terjadi duplikasi nama
        $image->storeAs('products', $imageName, 'public');

        // Simpan data produk ke database
        Product::create([
            'image' => $imageName,  // Gunakan nama file yang sudah di-hash
            'title' => $request->input('title'),
            'size' => $request->input('size'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock')
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil disimpan.');
    }

    // Menampilkan detail produk berdasarkan ID
    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    // Menampilkan form untuk mengedit produk berdasarkan ID
    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    // Mengupdate data produk yang ada
    public function update(Request $request, Product $product): RedirectResponse
    {
        // Validasi form
        $request->validate([
            'image' => 'sometimes|image|mimes:jpeg,jpg,png|max:2048', // 'sometimes' digunakan untuk optional
            'title' => 'required|min:5',
            'size' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required|min:10',
        ]);

        // Cek apakah ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                \Storage::delete('public/products/' . $product->image);
            }

            // Simpan gambar baru
            $image = $request->file('image');
            $imageName = $image->hashName(); // Gunakan hash name untuk gambar baru
            $image->storeAs('products', $imageName, 'public');
            $product->image = $imageName;
        }

        // Update data produk
        $product->update([
            'title' => $request->title,
            'size' => $request->size,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $product->image, // tetap gunakan gambar lama jika tidak ada gambar baru
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate.');
    }

    // Menghapus produk berdasarkan ID
    public function destroy(Product $product): RedirectResponse
    {
        // Hapus gambar dari storage
        if ($product->image) {
            \Storage::delete('public/products/' . $product->image);
        }

        // Hapus data produk dari database
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
