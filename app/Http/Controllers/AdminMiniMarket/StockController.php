<?php

namespace App\Http\Controllers\AdminMiniMarket;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])->latest()->paginate(15);
        return view('admin-mini-market.stocks.index', compact('transactions'));
    }

    public function createIn()
    {
        $products = Product::orderBy('name')->get();
        return view('admin-mini-market.stocks.create_in', compact('products'));
    }

    public function storeIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($request->product_id);
            $previousStock = $product->stock;
            $newStock = $previousStock + $request->quantity;

            $product->update(['stock' => $newStock]);

            StockTransaction::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $request->quantity,
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'notes' => $request->notes,
                'user_id' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('admin-mini-market.stocks.index')->with('success', 'Stok masuk berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function createOut()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('admin-mini-market.stocks.create_out', compact('products'));
    }

    public function storeOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($request->product_id);
            
            if ($request->quantity > $product->stock) {
                return back()->with('error', 'Jumlah stok keluar tidak boleh melebihi stok saat ini (' . $product->stock . ')')->withInput();
            }

            $previousStock = $product->stock;
            $newStock = $previousStock - $request->quantity;

            $product->update(['stock' => $newStock]);

            StockTransaction::create([
                'product_id' => $product->id,
                'type' => 'out',
                'quantity' => $request->quantity,
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'notes' => $request->notes,
                'user_id' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('admin-mini-market.stocks.index')->with('success', 'Stok keluar berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function createOpname()
    {
        $products = Product::orderBy('name')->get();
        return view('admin-mini-market.stocks.create_opname', compact('products'));
    }

    public function storeOpname(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'actual_stock' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($request->product_id);
            $previousStock = $product->stock;
            $newStock = $request->actual_stock;
            
            if ($previousStock == $newStock) {
                return back()->with('error', 'Stok fisik sama dengan stok sistem, tidak ada perubahan yang perlu dicatat.')->withInput();
            }

            $quantityDiff = abs($newStock - $previousStock);

            $product->update(['stock' => $newStock]);

            StockTransaction::create([
                'product_id' => $product->id,
                'type' => 'opname',
                'quantity' => $quantityDiff, // Catat selisihnya
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'notes' => $request->notes,
                'user_id' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('admin-mini-market.stocks.index')->with('success', 'Stok opname berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
