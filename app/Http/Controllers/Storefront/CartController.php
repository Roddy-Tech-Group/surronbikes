<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): View
    {
        $items = $this->cartService->getCartItems();
        $subtotal = $this->cartService->getSubtotal();
        $total = $this->cartService->getTotal();

        return view('storefront.cart.index', compact('items', 'subtotal', 'total'));
    }

    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $this->cartService->add((int)$request->product_id, (int)$request->quantity);

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        $this->cartService->update((int)$request->product_id, (int)$request->quantity);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $this->cartService->remove((int)$request->product_id);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        $this->cartService->clear();

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
