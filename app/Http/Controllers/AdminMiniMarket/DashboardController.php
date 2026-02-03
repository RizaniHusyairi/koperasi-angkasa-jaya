<?php

namespace App\Http\Controllers\AdminMiniMarket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingOrders = Order::where('status', 'Pending')->count();
        $salesToday = Order::whereDate('created_at', now()->today())
                           ->where('status', 'Completed')
                           ->sum('total_amount');
        $lowStockProducts = Product::where('stock', '<', 10)->count();
        
        // Latest orders
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin-mini-market.dashboard', compact('pendingOrders', 'salesToday', 'lowStockProducts', 'latestOrders'));
    }
}
