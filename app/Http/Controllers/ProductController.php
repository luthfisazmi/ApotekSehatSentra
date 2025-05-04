<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('home', compact('products')); // Pastikan view produk benar
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Simpan gambar jika diunggah
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_url' => $imagePath
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hapus gambar lama jika ada gambar baru diunggah
        if ($request->hasFile('image')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $product->image_url = $request->file('image')->store('products', 'public');
        }

        // Update data produk
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,  // Menambahkan stok yang sudah ada dengan stok baru
            'image_url' => $product->image_url
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // soft delete

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }


    public function home()
    {
        $products = Product::all(); // Ambil semua produk
        return view('home', compact('products')); // Pastikan ada file home.blade.php
    }

    public function restoreAll()
    {
        Product::onlyTrashed()->restore();

        return redirect()->route('products.index')->with('success', 'Semua produk berhasil dikembalikan!');
    }

    public function trashed()
        {
            $trashedProducts = Product::onlyTrashed()->get();
            return view('products.trashed', compact('trashedProducts'));
        }
        
        public function restore($id)
        {
            $product = Product::onlyTrashed()->where('id', $id)->first();
            
            if ($product) {
                $product->restore();
                
                // Restore transaksi yang terkait dengan produk ini
                Transaction::where('product_id', $id)->restore();
                
                return redirect()->route('products.trashed')->with('success', 'Produk dan transaksi terkait berhasil dikembalikan.');
            }
        
            return redirect()->route('products.trashed')->with('error', 'Produk tidak ditemukan.');
        }
        
}
