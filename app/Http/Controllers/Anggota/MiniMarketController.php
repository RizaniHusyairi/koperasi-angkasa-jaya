<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MiniMarketController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $products = $query->where('stock', '>', 0)->latest()->paginate(12);
        
        // Cart count
        $cart = session()->get('cart', []);
        $cartCount = count($cart);

        return view('anggota.mini-market.index', compact('products', 'cartCount'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        if(!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity']++;
        } else {
            $cart[$request->product_id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $user = auth()->user();
        $anggota = $user->anggota;
        
        // Calculate limit
        $limit = $anggota->limit_pinjaman ?? 0;
        $currentUsage = $anggota->jumlah_belanja_minimarket ?? 0;
        $remainingLimit = $limit - $currentUsage;

        return view('anggota.mini-market.cart', compact('cart', 'total', 'remainingLimit'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        $total = 0;
        foreach($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $user = auth()->user();
        $anggota = $user->anggota; // Ensure relationship exists
        
        if ($request->payment_method == 'Limit') {
            $limit = $anggota->limit_pinjaman ?? 0;
            $currentUsage = $anggota->jumlah_belanja_minimarket ?? 0;
            $remainingLimit = $limit - $currentUsage;

            if ($total > $remainingLimit) {
                return redirect()->back()->with('error', 'Sisa limit belanja tidak mencukupi. Sisa limit: Rp ' . number_format($remainingLimit, 0, ',', '.'));
            }
        }

        DB::beginTransaction();

        try {
            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'code' => 'INV-' . date('Ymd') . '-' . rand(1000, 9999),
                'total_amount' => $total,
                'status' => 'Pending', // Or 'Processed' if auto-approved? Let's keep Pending.
                'payment_method' => $request->payment_method ?? 'Limit',
            ]);

            // Create OrderItems and Update Stock
            foreach($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
                
                // Decrement stock
                $product = Product::find($id);
                if ($product) {
                     $product->decrement('stock', $item['quantity']);
                }
            }

            // Update Limit Usage if Payment is Limit
            if ($request->payment_method == 'Limit') {
                $anggota->increment('jumlah_belanja_minimarket', $total);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('anggota.mini-market.orders')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('anggota.mini-market.orders', compact('orders'));
    }
}
