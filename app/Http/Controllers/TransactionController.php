<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('product')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'buyer_name' => 'required|string|max:255',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'amount_paid' => 'required|integer|min:1'
    ]);

    $product = Product::findOrFail($request->product_id);

    if ($product->stock < $request->quantity) {
        return redirect()->back()->with('error', 'Stok tidak mencukupi!');
    }

    $total_price = $product->price * $request->quantity;
    
    if ($request->amount_paid < $total_price) {
        return redirect()->back()->with('error', 'Uang tidak cukup untuk membayar!');
    }

    // Hitung kembalian
    $change_amount = $request->amount_paid - $total_price;

    // Buat transaksi
    $transaction = Transaction::create([
        'buyer_name' => $request->buyer_name,
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'total_price' => $total_price,
        'amount_paid' => $request->amount_paid,
        'status' => 'pending',
    ]);

    // Kurangi stok produk
    $product->stock -= $request->quantity;
    $product->save();

    return redirect()->route('transactions.index')->with('success', "Transaksi berhasil! Kembalian: Rp " . number_format($change_amount, 0, ',', '.'));
    }


    

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function restoreAll()
    {
        Transaction::onlyTrashed()->restore(); // Restore transaksi yang terhapus
        
        return redirect()->route('transactions.index')->with('success', 'Semua transaksi berhasil dikembalikan!');
    }

    public function restore($id)
    {
        $transaction = Transaction::onlyTrashed()->where('id', $id)->first();

        if ($transaction) {
            $transaction->restore();
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dikembalikan.');
        }

        return redirect()->route('transactions.index')->with('error', 'Transaksi tidak ditemukan.');
    }
}