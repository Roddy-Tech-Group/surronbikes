<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'revenue' => Order::revenue()->sum('total'),
            'total_products' => Product::count(),
        ];

        $recentOrders = Order::with('paymentMethod')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
