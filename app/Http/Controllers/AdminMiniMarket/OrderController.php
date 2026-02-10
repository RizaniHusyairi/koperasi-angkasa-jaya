<?php

namespace App\Http\Controllers\AdminMiniMarket;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\MiniMarketSetting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin-mini-market.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        $setting = MiniMarketSetting::first();
        return view('admin-mini-market.orders.show', compact('order', 'setting'));
    }

    public function print(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        $setting = MiniMarketSetting::first();
        return view('admin-mini-market.orders.print', compact('order', 'setting'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Completed,Cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin-mini-market.orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function anggota()
    {
        $anggotaList = User::role('anggota')->with('anggota')->withCount('orders')->paginate(10);

        return view('admin-mini-market.members.index', compact('anggotaList'));
    }

    public function anggotaShow(User $anggota)
    {
        $user = $anggota;
        $user->load(['anggota', 'orders' => function($q) {
            $q->latest();
        }]);
        
        return view('admin-mini-market.members.show', compact('user'));
    }
}
