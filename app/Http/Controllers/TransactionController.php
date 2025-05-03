<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    // Menampilkan isi keranjang
    public function index()
    {
        $cart = session()->get('cart', []);

        $cartItems = collect($cart)->map(function ($item, $productId) {
            $product = Product::find($productId);
            if (!$product) return null;

            $item['product'] = $product;
            return (object) $item;
        })->filter();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('transactions.index', compact('cartItems', 'totalPrice'));
    }

    // Tombol Beli Sekarang
    public function checkoutNow($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);
        $cart[$id] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
        ];
        session()->put('cart', $cart);

        return redirect()->route('transactions.index');
    }

    // Tambah ke keranjang
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('transactions.index')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    // Kurangi kuantitas dari cart
    public function decreaseFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('transactions.index')->with('success', 'Kuantitas produk dikurangi.');
    }

    // Update kuantitas langsung
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;

        if (!isset($cart[$id])) {
            return response()->json(['error' => 'Produk tidak ditemukan di cart.'], 404);
        }

        $cart[$id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        $product = Product::find($id);
        $updatedSubtotal = $product->price * $cart[$id]['quantity'];
        $total = collect($cart)->reduce(function ($carry, $item) use ($product) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return response()->json([
            'success' => true,
            'updatedQuantity' => $cart[$id]['quantity'],
            'updatedSubtotal' => $updatedSubtotal,
            'total' => $total,
        ]);
    }

    // Checkout page
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $cartItems = collect($cart)->map(function ($item, $productId) {
            $product = Product::find($productId);
            if (!$product) return null;

            $item['product'] = $product;
            return (object) $item;
        })->filter();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('transactions.index', compact('cartItems', 'totalPrice'));
    }

    // Proses transaksi
    public function processCheckout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $request->validate([
            'buyer_name'     => 'required|string|max:255',
            'buyer_email'    => 'required|email',
            'buyer_address'  => 'required|string',
            'payment_method' => 'required|in:transfer,cod',
            'sub_payment'    => 'nullable|string',
        ]);

        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $transaction = Transaction::create([
            'buyer_name'     => $request->buyer_name,
            'buyer_email'    => $request->buyer_email,
            'buyer_address'  => $request->buyer_address,
            'payment_method' => $request->payment_method,
            'sub_payment'    => $request->sub_payment,
            'total_price'    => $total,
            'status'         => 'Menunggu Konfirmasi',
        ]);

        foreach ($cart as $productId => $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $productId,
                'quantity'       => $item['quantity'],
                'price'          => $item['price'],
            ]);

            $product = Product::find($productId);
            if ($product && $product->stock >= $item['quantity']) {
                $product->decrement('stock', $item['quantity']);
            } else {
                Log::warning("Stok tidak cukup untuk produk ID: $productId");
            }
        }

        session()->forget('cart');

        return redirect()->route('transactions.success')->with('success', 'Transaksi berhasil diproses!');
    }

    // Hapus dari keranjang
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('transactions.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    // Transaksi berhasil
    public function success()
    {
        return view('transactions.transaction-success');
    }

    // Hapus transaksi (admin)
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
    }

    // Admin: daftar semua transaksi
    public function all()
    {
        $transactions = Transaction::with('items.product')->latest()->get();
        return view('transactions.all', compact('transactions'));
    }
}
