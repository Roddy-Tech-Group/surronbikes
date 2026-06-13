<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackingController extends Controller
{
    public function index(): View
    {
        return view('storefront.tracking.index');
    }

    public function search(Request $request): RedirectResponse
    {
        $request->validate([
            'order_number' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->where('customer_email', $request->email)
            ->first();

        if (!$order) {
            return back()->withInput()->with('error', 'We could not find an order matching that information. Please check your order number and email address.');
        }

        return redirect()->route('tracking.show', $order->order_number);
    }

    public function show(string $orderNumber): View
    {
        $order = Order::with(['items', 'statusHistories'])->where('order_number', $orderNumber)->firstOrFail();
        
        return view('storefront.tracking.show', compact('order'));
    }
}
