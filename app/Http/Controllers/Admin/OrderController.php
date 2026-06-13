<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRejectRequest;
use App\Http\Requests\Admin\OrderStatusUpdateRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    /**
     * Display a listing of orders with filtering.
     */
    public function index(Request $request): View
    {
        $query = Order::with('paymentMethod')->latest();

        // Search Filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Status Filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Date Range Filter
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order details.
     */
    public function show(Order $order): View
    {
        $order->load(['items.product', 'paymentMethod', 'statusHistories.admin']);
        
        $allowedTransitions = $this->orderService->getAllowedTransitions($order->status);

        return view('admin.orders.show', compact('order', 'allowedTransitions'));
    }

    /**
     * Approve the payment.
     */
    public function approvePayment(Order $order): RedirectResponse
    {
        try {
            $this->orderService->approvePayment($order, auth()->guard('admin')->user());
            return back()->with('success', 'Payment has been approved and the customer has been notified.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Reject the payment.
     */
    public function rejectPayment(OrderRejectRequest $request, Order $order): RedirectResponse
    {
        try {
            $this->orderService->rejectPayment(
                $order, 
                auth()->guard('admin')->user(), 
                $request->validated('rejection_reason')
            );
            return back()->with('success', 'Payment has been rejected. The order is cancelled and the customer has been notified.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the generic status of the order.
     */
    public function updateStatus(OrderStatusUpdateRequest $request, Order $order): RedirectResponse
    {
        try {
            $this->orderService->updateStatus(
                $order, 
                auth()->guard('admin')->user(), 
                $request->validated('status')
            );
            return back()->with('success', 'Order status has been updated and the customer has been notified.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Download the uploaded payment proof.
     */
    public function downloadProof(Order $order): StreamedResponse|RedirectResponse
    {
        if (!$order->payment_proof_path || !Storage::disk('public')->exists($order->payment_proof_path)) {
            return back()->with('error', 'Payment proof file not found.');
        }

        return Storage::disk('public')->download(
            $order->payment_proof_path,
            "payment-proof-{$order->order_number}." . pathinfo($order->payment_proof_path, PATHINFO_EXTENSION)
        );
    }
}
