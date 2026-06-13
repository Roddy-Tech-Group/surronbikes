<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartService
{
    private const COOKIE_NAME = 'suronbikes_cart';
    private const COOKIE_LIFETIME = 60 * 24 * 30; // 30 days in minutes

    public function getCart(): array
    {
        $cartJson = Cookie::get(self::COOKIE_NAME);
        if (!$cartJson) {
            return [];
        }

        $cart = json_decode($cartJson, true);
        return is_array($cart) ? $cart : [];
    }

    public function getCartItems(): array
    {
        $cart = $this->getCart();
        $items = [];
        
        if (empty($cart)) {
            return $items;
        }

        // We load the products from the DB to ensure prices are up to date
        // and we have access to images, slugs, etc.
        $products = Product::whereIn('id', array_keys($cart))->with(['category', 'primaryImage', 'images'])->get()->keyBy('id');

        foreach ($cart as $productId => $quantity) {
            if ($products->has($productId)) {
                $product = $products->get($productId);
                $items[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'line_total' => $product->price * $quantity,
                    'category' => $product->category->name ?? '',
                    'image_url' => $this->getProductPrimaryImageUrl($product)
                ];
            } else {
                // Product no longer exists, remove from cart
                $this->remove($productId);
            }
        }

        return $items;
    }

    public function getSubtotal(): float
    {
        return collect($this->getCartItems())->sum('line_total');
    }

    public function getTotal(): float
    {
        // Add taxes or shipping here later if needed
        return collect($this->getCartItems())->sum('line_total');
    }

    public function getCount(): int
    {
        return collect($this->getCart())->sum();
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $cart = $this->getCart();
        
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        $this->saveCart($cart);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->getCart();
        
        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }

        $this->saveCart($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->getCart();
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $this->saveCart($cart);
        }
    }

    public function clear(): void
    {
        Cookie::queue(Cookie::forget(self::COOKIE_NAME));
    }

    private function saveCart(array $cart): void
    {
        Cookie::queue(self::COOKIE_NAME, json_encode($cart), self::COOKIE_LIFETIME);
    }

    private function getProductPrimaryImageUrl(Product $product): ?string
    {
        if ($product->primaryImage) {
            return $product->primaryImage->path;
        }
        
        $first = $product->images->first();
        if ($first) {
            return $first->path;
        }

        return null; 
    }
}
