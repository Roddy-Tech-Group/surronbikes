<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    private CartService $cartService;
    private OrderService $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index(): View|RedirectResponse
    {
        $items = $this->cartService->getCartItems();
        
        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add some products before checking out.');
        }

        $subtotal = $this->cartService->getSubtotal();
        $total = $this->cartService->getTotal();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('storefront.checkout.index', compact('items', 'subtotal', 'total', 'paymentMethods'));
    }

    public function store(Request $request): RedirectResponse
    {
        $items = $this->cartService->getCartItems();
        
        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            // Customer Info
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:255'],
            
            // Shipping Info
            'shipping_country' => ['required', 'string', 'max:255'],
            'shipping_state' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_postal_code' => ['required', 'string', 'max:255'],
            
            // Payment
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:20480'], // 20MB max
        ]);

        // Upload payment proof
        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        $totalAmount = $this->cartService->getTotal();

        // Create the order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'status' => Order::STATUS_PENDING_VERIFICATION,
            'total' => $totalAmount,
            'payment_method_id' => $validated['payment_method_id'],
            'payment_proof_path' => $proofPath,
            
            // Customer Details
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            
            // Shipping Details
            'shipping_country' => $validated['shipping_country'],
            'shipping_state' => $validated['shipping_state'],
            'shipping_city' => $validated['shipping_city'],
            'shipping_address' => $validated['shipping_address'],
            'shipping_postal_code' => $validated['shipping_postal_code'],
            
            // If tracking is added later
            'tracking_number' => null,
            'carrier' => null,
        ]);

        // Create order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'product_price' => $item['price'],
                'subtotal' => $item['line_total'],
            ]);
        }

        // Log the initial order creation history
        \App\Models\OrderStatusHistory::create([
            'order_id' => $order->id,
            'admin_id' => null,
            'previous_status' => Order::STATUS_PENDING_VERIFICATION,
            'new_status' => Order::STATUS_PENDING_VERIFICATION,
            'reason' => 'Order placed by customer, awaiting payment verification.',
        ]);

        // Clear the cart
        $this->cartService->clear();

        return redirect()->route('tracking.show', ['order_number' => $order->order_number])
            ->with('success', 'Your order has been placed successfully! We will review your payment and update the status shortly.');
    }
}
