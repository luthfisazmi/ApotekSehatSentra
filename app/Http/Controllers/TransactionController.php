<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    /* =======================
     * KERANJANG BELANJA
     * ======================= */

    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = $this->getCartItems($cart);

        return view('transactions.index', compact('cartItems'));
    }

    public function checkoutNow($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $cart[$id] = [
            'product_id' => $product->id,
            'name'       => $product->name,
            'price'      => $product->price,
            'quantity'   => 1,
        ];
        session()->put('cart', $cart);

        return redirect()->route('transactions.index');
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'quantity'   => 1,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('transactions.index')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('transactions.index')->with('success', 'Produk dihapus dari keranjang.');
    }

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
            'success'          => true,
            'updatedQuantity'  => $quantity,
            'updatedSubtotal'  => $quantity * $cart[$id]['price'],
            'total'            => $total,
        ]);
    }

    /* =======================
     * PROSES CHECKOUT
     * ======================= */

    public function processCheckout(Request $request)
    {
        Log::info('Checkout request:', $request->all());

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong.');
        }

        $validated = $request->validate([
            'buyer_name'     => 'required|string|max:255',
            'email'          => 'required|email',
            'address'        => 'nullable|string',
            'payment_method' => 'required|in:transfer,cod',
            'sub_payment'    => 'nullable|string',
            'amount_paid'    => 'nullable|numeric|min:0',
        ]);

        $cartItems = $this->getCartItems($cart);
        $totalPrice = $this->calculateTotalPrice($cartItems);
        $totalQuantity = collect($cart)->sum('quantity');
        $paymentMethod = $validated['payment_method'];
        $sub_payment = $paymentMethod === 'cod' ? null : $validated['sub_payment'];
        $change = 0;

        if ($paymentMethod === 'transfer' && empty($validated['sub_payment'])) {
            return back()->with('error', 'Pilih bank untuk pembayaran transfer.');
        }

        if ($paymentMethod === 'cod') {
            if (!isset($validated['amount_paid']) || $validated['amount_paid'] < $totalPrice) {
                return back()->with('error', 'Jumlah uang yang dibayar kurang dari total belanja.');
            }
            $change = $validated['amount_paid'] - $totalPrice;
        }

        $transaction = Transaction::create([
            'admin_id'       => auth('admin')->id(),
            'buyer_name'     => $validated['buyer_name'],
            'email'          => $validated['email'],
            'address'        => $validated['address'] ?? '-',
            'quantity'       => $totalQuantity,
            'total_price'    => $totalPrice,
            'amount_paid'    => $validated['amount_paid'] ?? 0,
            'payment_method' => $paymentMethod,
            'sub_payment'    => $sub_payment,
            'change'         => $change,
            'status'         => 'Sukses',
        ]);

        foreach ($cart as $productId => $item) {
            $product = Product::findOrFail($productId);

            if ($product->stock < $item['quantity']) {
                return redirect()->back()->with('error', 'Stok produk ' . $product->name . ' tidak mencukupi!');
            }

            $product->stock -= $item['quantity'];
            $product->save();

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $productId,
                'quantity'       => $item['quantity'],
                'price'          => $product->price,
            ]);
        }

        session()->forget('cart');

        return redirect()->route('transactions.success', ['transactionId' => $transaction->id])
            ->with('success', 'Transaksi berhasil!');
    }

    public function success($transactionId)
    {
        $transaction = Transaction::with('transactionItems.product')->findOrFail($transactionId);
        return view('transactions.success', compact('transaction'));
    }

    /* =======================
     * RIWAYAT TRANSAKSI
     * ======================= */

    public function history()
    {
        $adminId = auth('admin')->id();
        $transactions = Transaction::where('admin_id', $adminId)->with('transactionItems.product')->get();

        return view('transactions.history', compact('transactions'));
    }

    public function showHistory()
    {
        $admin = auth('admin')->user();
        if (!$admin) abort(403, 'Unauthorized');

        $transactions = $admin->role === 'admin'
            ? Transaction::with('transactionItems.product')->get()
            : Transaction::where('admin_id', $admin->id)->with('transactionItems.product')->get();

        return view('transactions.history', compact('transactions'));
    }

    public function indexForAdmin()
    {
        $transactions = Transaction::with(['transactionItems.product'])->orderBy('created_at', 'desc')->get();
        return view('transactions.history', compact('transactions'));
    }

    /* =======================
     * PDF INVOICE
     * ======================= */

    public function generatePdfInvoice($transactionId)
    {
        $transaction = Transaction::with('transactionItems.product')->findOrFail($transactionId);
        $pdf = Pdf::loadView('transactions.invoicePdf', compact('transaction'));

        return $pdf->stream('invoice-transaksi-' . $transaction->id . '.pdf');
    }

    /* =======================
     * ADMIN TOOLS
     * ======================= */

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
    }

    public function restoreAll()
{
    // Cek apakah user yang login adalah admin
    $admin = auth('admin')->user();
    if (!$admin || $admin->role !== 'admin') {
        abort(403, 'Unauthorized');
    }

    Transaction::onlyTrashed()->restore();

    return redirect()->route('transactions.history')->with('success', 'Semua transaksi berhasil dipulihkan.');
}


    public function all()
    {
        $transactions = Transaction::with('items.product')->latest()->get();
        return view('transactions.all', compact('transactions'));
    }

    /* =======================
     * HELPER FUNCTIONS
     * ======================= */

    protected function calculateTotalPrice($cartItems)
    {
        return $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }

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
