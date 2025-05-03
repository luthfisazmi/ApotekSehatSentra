<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    // Tampilkan isi keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = $this->getCartItems($cart);
        
        return view('transactions.index', compact('cartItems'));
    }

    // Button "Checkout"
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

    // Button "Tambah Produk"
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

    // Update kuantitas langsung via input
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;
        $quantity = max((int) $request->quantity, 0);

        if (!isset($cart[$id])) {
            return response()->json(['error' => 'Produk tidak ditemukan di cart.'], 404);
        }

        if ($quantity <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return response()->json([
            'success' => true,
            'updatedQuantity' => $quantity,
            'updatedSubtotal' => $quantity * $cart[$id]['price'],
            'total' => $total,
        ]);
    }

    
    // Proses checkout
    public function processCheckout(Request $request)
{
    Log::info('Checkout request:', $request->all());

    // Ambil data keranjang belanja
    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->back()->with('error', 'Keranjang belanja kosong.');
    }

    // Validasi inputan
    $validated = $request->validate([
        'buyer_name' => 'required|string|max:255',
        'email' => 'required|email',
        'address' => 'nullable|string',
        'payment_method' => 'required|in:transfer,cod',
        'sub_payment' => 'nullable|string',
        'amount_paid' => 'nullable|numeric|min:0', // Optional, hanya untuk COD
    ]);

    // Mendapatkan item keranjang dan total harga
    $cartItems = $this->getCartItems($cart);
    $totalPrice = $this->calculateTotalPrice($cartItems);

    // Hitung total quantity di cart
    $totalQuantity = collect($cart)->sum('quantity');

    // Ambil payment_method
    $paymentMethod = $validated['payment_method'];

    // Cek apakah 'sub_payment' ada dan valid hanya jika payment_method adalah 'transfer'
    if ($paymentMethod === 'transfer' && empty($validated['sub_payment'])) {
        return back()->with('error', 'Pilih bank untuk pembayaran transfer.');
    }

    // Tentukan nilai sub_payment
    $sub_payment = $paymentMethod === 'cod' ? 0 : $validated['sub_payment'];

    $change = 0;

    // Logika pembayaran COD
    if ($paymentMethod === 'cod') {
        if (!isset($validated['amount_paid']) || $validated['amount_paid'] < $totalPrice) {
            return back()->with('error', 'Jumlah uang yang dibayar kurang dari total belanja.');
        }
        $change = $validated['amount_paid'] - $totalPrice;
    }

    // Menyimpan transaksi dengan nama, email, alamat, dll.
    $transaction = Transaction::create([
        'admin_id' => auth('admin')->id(),
        'buyer_name' => $request->buyer_name,
        'email' => $request->email,
        'address' => $request->address ?? '-',
        'quantity' => $totalQuantity, // Menambahkan total quantity
        'total_price' => $totalPrice,
        'amount_paid' => $request->amount_paid ?? 0,
        'payment_method' => $request->payment_method,
        'sub_payment' => $sub_payment,  // Menggunakan nilai sub_payment yang sudah dihitung
        'change' => $change,
        'status' => 'Sukses',
    ]);

    // Menyimpan item transaksi
    foreach ($cart as $productId => $item) {
        $product = Product::findOrFail($productId);

        // Cek stok tersedia
        if ($product->stock < $item['quantity']) {
            return redirect()->back()->with('error', 'Stok produk ' . $product->name . ' tidak mencukupi!');
        }

        // Kurangi stok produk
        $product->stock -= $item['quantity'];
        $product->save();

        // Simpan item transaksi
        TransactionItem::create([
            'transaction_id' => $transaction->id,
            'product_id' => $productId,
            'quantity' => $item['quantity'],
            'price' => $product->price, // Menambahkan harga produk
        ]);
    }

    // Menghapus keranjang belanja setelah transaksi berhasil
    session()->forget('cart');

    // Mengarahkan ke halaman riwayat transaksi
    return redirect()->route('transactions.success', ['transactionId' => $transaction->id])
    ->with('success', 'Transaksi berhasil!');
}

public function success($transactionId)
{
    // Mendapatkan transaksi berdasarkan ID yang diterima
    $transaction = Transaction::with('transactionItems.product')
                              ->findOrFail($transactionId);

    // Mengirimkan data transaksi ke view
    return view('transactions.success', compact('transaction'));
}

public function generatePdfInvoice($transactionId)
{
    $transaction = Transaction::with('transactionItems.product')->findOrFail($transactionId);

    $pdf = Pdf::loadView('transactions.invoicePdf', compact('transaction'));

    return $pdf->stream('invoice-transaksi-' . $transaction->id . '.pdf');
}




public function history()
{
    $adminId = auth('admin')->id(); // atau sesuaikan dengan guard kamu
    $transactions = Transaction::where('admin_id', $adminId)->with('transactionItems.product')->get();

    return view('transactions.history', compact('transactions'));
}

public function showHistory()
{
    $admin = auth('admin')->user(); // pastiin ini dapet user yang login

    if (!$admin) {
        abort(403, 'Unauthorized'); // biar ketahuan kalo gak login
    }

    if ($admin->role === 'admin') {
        $transactions = Transaction::with('transactionItems.product')->get(); // admin liat semua
    } else {
        $transactions = Transaction::with('transactionItems.product')
            ->where('admin_id', $admin->id)
            ->get(); // user liat punyanya sendiri
    }

    return view('transactions.history', compact('transactions'));
}




    // Admin: Hapus transaksi
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete(); // Soft delete karena ada kolom deleted_at
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
    }

    // Admin: Lihat semua transaksi
    public function all()
    {
        $transactions = Transaction::with('items.product')->latest()->get();
        return view('transactions.all', compact('transactions'));
    }

    // Helper: hitung total harga
    protected function calculateTotalPrice($cartItems)
    {
        return $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

    // Helper: ambil cart item sebagai objek
    protected function getCartItems($cart)
    {
        return collect($cart)->map(function ($item, $productId) {
            $product = Product::find($productId);
            if (!$product) return null;

            $item['product'] = $product;
            return (object) $item;
        })->filter();
    }
}