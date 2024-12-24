<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required|min:5',
            'size' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required|min:10',
        ]);

        $image = $request->file('image');
        $imageName = $image->hashName();
        $image->storeAs('products', $imageName, 'public');

        Product::create([
            'image' => $imageName,
            'title' => $request->input('title'),
            'size' => $request->input('size'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock')
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil disimpan.');
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'image' => 'sometimes|image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required|min:5',
            'size' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required|min:10',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('products', $imageName, 'public');
            $product->image = $imageName;
        }

        $product->update([
            'title' => $request->title,
            'size' => $request->size,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $product->image,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::delete('public/products/' . $product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
