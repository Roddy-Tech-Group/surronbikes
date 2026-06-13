@extends('layouts.storefront')

@section('meta_title', 'Shopping Cart - ' . config('app.name'))

@section('content')
    <div class="bg-white py-12 sm:py-16 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Shopping Cart</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(empty($items))
            <div class="text-center py-24 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Your cart is empty</h3>
                <p class="mt-2 text-gray-500">Looks like you haven't added anything to your cart yet.</p>
                <div class="mt-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700">
                        Start Shopping
                    </a>
                </div>
            </div>
        @else
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($items as $item)
                                <li class="flex p-6 sm:p-8">
                                    <div class="flex-shrink-0 w-24 h-24 sm:w-32 sm:h-32 bg-gray-100 rounded-lg overflow-hidden border border-gray-100">
                                        @if($item['image_url'])
                                            <img src="{{ Storage::url($item['image_url']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 sm:ml-6 flex-1 flex flex-col min-w-0">
                                        <div class="flex justify-between gap-4">
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-sm font-medium text-orange-600 mb-1 truncate">{{ $item['category'] }}</h4>
                                                <h3 class="text-lg font-bold text-gray-900 truncate">
                                                    <a href="{{ route('products.show', $item['slug']) }}" class="hover:text-orange-600" title="{{ $item['name'] }}">{{ $item['name'] }}</a>
                                                </h3>
                                            </div>
                                            <p class="text-lg font-extrabold text-gray-900 whitespace-nowrap">${{ number_format($item['line_total'], 2) }}</p>
                                        </div>

                                        <div class="mt-4 flex-1 flex items-end justify-between">
                                            <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                                <label for="quantity-{{ $item['product_id'] }}" class="sr-only">Quantity</label>
                                                <select id="quantity-{{ $item['product_id'] }}" name="quantity" onchange="this.form.submit()" class="rounded-md border border-gray-300 text-base font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                                    @for($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <span class="ml-3 text-sm text-gray-500 hidden sm:inline">@ ${{ number_format($item['price'], 2) }} each</span>
                                            </form>

                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-500 transition-colors">
                                                    <span>Remove</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-6 flex justify-between items-center px-4 sm:px-0">
                        <a href="{{ route('home') }}" class="text-sm font-medium text-orange-600 hover:text-orange-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                            Continue Shopping
                        </a>
                        
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors" onclick="return confirm('Are you sure you want to clear your cart?')">
                                Clear Cart
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-4 mt-12 lg:mt-0">
                    <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6 sm:p-8">
                        <h2 class="text-xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-4">Order Summary</h2>

                        <dl class="space-y-4">
                            <div class="flex items-center justify-between text-base">
                                <dt class="text-gray-600">Subtotal</dt>
                                <dd class="font-medium text-gray-900">${{ number_format($subtotal, 2) }}</dd>
                            </div>
                            
                            {{-- Add taxes or shipping estimates here if needed --}}
                            <div class="flex items-center justify-between text-sm text-gray-500 italic">
                                <dt>Shipping</dt>
                                <dd>Calculated at checkout</dd>
                            </div>

                            <div class="border-t border-gray-200 pt-4 flex items-center justify-between text-lg font-bold text-gray-900">
                                <dt>Total</dt>
                                <dd>${{ number_format($total, 2) }}</dd>
                            </div>
                        </dl>

                        <div class="mt-8">
                            <a href="{{ route('checkout.index') }}" class="w-full flex items-center justify-center rounded-lg border border-transparent bg-orange-600 px-6 py-4 text-base font-bold text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-gray-50 transition-colors uppercase tracking-wide">
                                Proceed to Checkout
                            </a>
                        </div>
                        
                        <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                            <p>
                                Secure Checkout <br>
                                <span class="text-xs">Your payment information is handled safely.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
