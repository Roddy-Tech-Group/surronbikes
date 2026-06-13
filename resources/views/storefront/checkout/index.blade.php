@extends('layouts.storefront')

@section('meta_title', 'Secure Checkout - ' . config('app.name'))

@section('content')
    <div class="bg-white py-10 sm:py-14 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Secure Checkout</h1>
            <p class="mt-2 text-gray-500">Complete your order securely.</p>

            {{-- Step indicator --}}
            <div class="mt-8 flex items-center justify-center gap-0 max-w-md mx-auto">
                <div class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-600 text-white text-xs font-bold">1</span>
                    <span class="text-sm font-medium text-gray-900 hidden sm:inline">Contact</span>
                </div>
                <div class="flex-1 h-0.5 bg-gray-200 mx-2 sm:mx-4"></div>
                <div class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-600 text-white text-xs font-bold">2</span>
                    <span class="text-sm font-medium text-gray-900 hidden sm:inline">Shipping</span>
                </div>
                <div class="flex-1 h-0.5 bg-gray-200 mx-2 sm:mx-4"></div>
                <div class="flex items-center gap-2">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-600 text-white text-xs font-bold">3</span>
                    <span class="text-sm font-medium text-gray-900 hidden sm:inline">Payment</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            @csrf

            <div class="lg:col-span-7 space-y-8">
                
                {{-- Customer Information --}}
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-600 text-sm font-bold">1</span>
                        Contact Information
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                            @error('customer_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="customer_email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                            @error('customer_email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                            @error('customer_phone')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Shipping Information --}}
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-600 text-sm font-bold">2</span>
                        Shipping Address
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label for="shipping_address" class="block text-sm font-semibold text-gray-700 mb-2">Street Address</label>
                            <input type="text" id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" required>
                            @error('shipping_address')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="shipping_city" class="block text-sm font-semibold text-gray-700 mb-2">City</label>
                            <input type="text" id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}" required>
                            @error('shipping_city')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="shipping_state" class="block text-sm font-semibold text-gray-700 mb-2">State / Province</label>
                            <input type="text" id="shipping_state" name="shipping_state" value="{{ old('shipping_state') }}" required>
                            @error('shipping_state')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="shipping_postal_code" class="block text-sm font-semibold text-gray-700 mb-2">Postal Code</label>
                            <input type="text" id="shipping_postal_code" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" required>
                            @error('shipping_postal_code')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="shipping_country" class="block text-sm font-semibold text-gray-700 mb-2">Country</label>
                            <input type="text" id="shipping_country" name="shipping_country" value="{{ old('shipping_country', 'United States') }}" required>
                            @error('shipping_country')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-200" x-data="{ selectedMethod: '{{ old('payment_method_id') }}' }">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-600 text-sm font-bold">3</span>
                        Payment
                    </h2>
                    
                    <p class="text-sm text-gray-500 mb-6">Select your preferred payment method and follow the instructions. You must upload proof of payment to complete your order.</p>

                    <div class="space-y-3 mb-8">
                        @foreach($paymentMethods as $method)
                            <div class="border-2 rounded-xl overflow-hidden transition-all duration-200" :class="selectedMethod == '{{ $method->id }}' ? 'border-orange-500 bg-orange-50/30 shadow-sm' : 'border-gray-200 hover:border-gray-300'">
                                <label class="flex items-center p-4 cursor-pointer justify-between w-full">
                                    <div class="flex items-center">
                                        <input type="radio" name="payment_method_id" value="{{ $method->id }}" x-model="selectedMethod" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                                        <div class="ml-3 flex items-center gap-3">
                                            {{-- Prebuilt Logo --}}
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-gray-200 p-1 flex-shrink-0 shadow-sm">
                                                @if($method->type === \App\Models\PaymentMethod::TYPE_BANK)
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5M2.25 21h19.5" />
                                                    </svg>
                                                @elseif($method->type === \App\Models\PaymentMethod::TYPE_CRYPTO)
                                                    <svg class="w-5 h-5 text-amber-500" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M23.638 14.904c-1.602 6.43-8.113 10.34-14.542 8.736C2.67 22.05-1.244 15.525.362 9.105 1.962 2.67 8.475-1.243 14.9.358c6.43 1.605 10.342 8.115 8.738 14.548v-.002zm-6.35-4.613c.24-1.59-.974-2.45-2.64-3.03l.54-2.153-1.315-.33-.525 2.107c-.345-.087-.705-.167-1.064-.25l.526-2.127-1.32-.33-.54 2.165c-.285-.067-.565-.132-.84-.2l-1.815-.45-.35 1.407s.975.225.955.236c.535.136.63.486.615.766l-1.477 5.92c-.075.166-.24.406-.614.314.015.02-.96-.24-.96-.24l-.66 1.51 1.71.426.93.242-.54 2.19 1.32.327.54-2.17c.36.1.705.19 1.05.273l-.51 2.154 1.32.33.545-2.19c2.24.427 3.93.257 4.64-1.774.57-1.637-.03-2.58-1.217-3.196.854-.193 1.5-.76 1.68-1.93h.01zm-3.01 4.22c-.404 1.64-3.157.75-4.05.53l.72-2.9c.896.23 3.757.67 3.33 2.37zm.41-4.24c-.37 1.49-2.662.735-3.405.55l.654-2.64c.744.18 3.137.524 2.75 2.084v.006z"/>
                                                    </svg>
                                                @elseif($method->type === \App\Models\PaymentMethod::TYPE_ZELLE)
                                                    <svg class="w-5 h-5 text-purple-600" role="img" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M13.559 24h-2.841a.483.483 0 0 1-.483-.483v-2.765H5.638a.667.667 0 0 1-.666-.666v-2.234a.67.67 0 0 1 .142-.412l8.139-10.382h-7.25a.667.667 0 0 1-.667-.667V3.914c0-.367.299-.666.666-.666h4.23V.483c0-.266.217-.483.483-.483h2.841c.266 0 .483.217.483.483v2.765h4.323c.367 0 .666.299.666.666v2.137a.67.67 0 0 1-.141.41l-8.19 10.481h7.665c.367 0 .666.299.666.666v2.477a.667.667 0 0 1-.666.667h-4.32v2.765a.483.483 0 0 1-.483.483Z"/>
                                                    </svg>
                                                @elseif($method->type === \App\Models\PaymentMethod::TYPE_CASHAPP)
                                                    <svg class="w-5 h-5 text-emerald-500" role="img" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M23.59 3.475a5.1 5.1 0 00-3.05-3.05c-1.31-.42-2.5-.42-4.92-.42H8.36c-2.4 0-3.61 0-4.9.4a5.1 5.1 0 00-3.05 3.06C0 4.765 0 5.965 0 8.365v7.27c0 2.41 0 3.6.4 4.9a5.1 5.1 0 003.05 3.05c1.3.41 2.5.41 4.9.41h7.28c2.41 0 3.61 0 4.9-.4a5.1 5.1 0 003.06-3.06c.41-1.3.41-2.5.41-4.9v-7.25c0-2.41 0-3.61-.41-4.91zm-6.17 4.63l-.93.93a.5.5 0 01-.67.01 5 5 0 00-3.22-1.18c-.97 0-1.94.32-1.94 1.21 0 .9 1.04 1.2 2.24 1.65 2.1.7 3.84 1.58 3.84 3.64 0 2.24-1.74 3.78-4.58 3.95l-.26 1.2a.49.49 0 01-.48.39H9.63l-.09-.01a.5.5 0 01-.38-.59l.28-1.27a6.54 6.54 0 01-2.88-1.57v-.01a.48.48 0 010-.68l1-.97a.49.49 0 01.67 0c.91.86 2.13 1.34 3.39 1.32 1.3 0 2.17-.55 2.17-1.42 0-.87-.88-1.1-2.54-1.72-1.76-.63-3.43-1.52-3.43-3.6 0-2.42 2.01-3.6 4.39-3.71l.25-1.23a.48.48 0 01.48-.38h1.78l.1.01c.26.06.43.31.37.57l-.27 1.37c.9.3 1.75.77 2.48 1.39l.02.02c.19.2.19.5 0 .68z"/>
                                                    </svg>
                                                @elseif($method->type === \App\Models\PaymentMethod::TYPE_PAYPAL)
                                                    <svg class="w-5 h-5 text-blue-600" role="img" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M15.607 4.653H8.941L6.645 19.251H1.82L4.862 0h7.995c3.754 0 6.375 2.294 6.473 5.513-.648-.478-2.105-.86-3.722-.86m6.57 5.546c0 3.41-3.01 6.853-6.958 6.853h-2.493L11.595 24H6.74l1.845-11.538h3.592c4.208 0 7.346-3.634 7.153-6.949a5.24 5.24 0 0 1 2.848 4.686M9.653 5.546h6.408c.907 0 1.942.222 2.363.541-.195 2.741-2.655 5.483-6.441 5.483H8.714Z"/>
                                                    </svg>
                                                @elseif($method->type === \App\Models\PaymentMethod::TYPE_MOBILE_MONEY)
                                                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <span class="font-semibold text-gray-900">{{ $method->name }}</span>
                                        </div>
                                    </div>
                                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded bg-gray-100 text-gray-500 hidden sm:inline-block">
                                        {{ $method->type_label }}
                                    </span>
                                </label>
                                
                                <div x-show="selectedMethod == '{{ $method->id }}'" x-collapse class="px-4 pb-4 pl-11 text-sm text-gray-600">
                                    <div class="bg-white p-5 rounded-xl border border-orange-100 shadow-sm space-y-4">
                                        {{-- Account Details Block --}}
                                        @if(!empty($method->details))
                                            <div>
                                                <h4 class="font-bold text-gray-900 mb-2.5">Payment details</h4>
                                                <div class="bg-orange-50/20 rounded-lg p-4 border border-orange-100/50 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 font-medium text-gray-700">
                                                    @if($method->type === \App\Models\PaymentMethod::TYPE_BANK)
                                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Bank Name</span> <span class="text-gray-900 font-semibold">{{ $method->details['bank_name'] ?? 'N/A' }}</span></div>
                                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Account Name</span> <span class="text-gray-900 font-semibold">{{ $method->details['account_name'] ?? 'N/A' }}</span></div>
                                                        <div>
                                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Account Number</span>
                                                            <div class="flex items-center gap-1.5">
                                                                <span class="text-gray-950 font-mono font-bold select-all">{{ $method->details['account_number'] ?? 'N/A' }}</span>
                                                                @if(!empty($method->details['account_number']))
                                                                    <button type="button" onclick="copyToClipboard('{{ $method->details['account_number'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy Account Number">
                                                                        <svg class="w-3.5 h-3.5 copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                        </svg>
                                                                        <svg class="w-3.5 h-3.5 check-icon hidden text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Routing / Sort Code</span>
                                                            <div class="flex items-center gap-1.5">
                                                                <span class="text-gray-900 font-mono select-all">{{ $method->details['routing_number'] ?? 'N/A' }}</span>
                                                                @if(!empty($method->details['routing_number']))
                                                                    <button type="button" onclick="copyToClipboard('{{ $method->details['routing_number'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy Routing Code">
                                                                        <svg class="w-3.5 h-3.5 copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                        </svg>
                                                                        <svg class="w-3.5 h-3.5 check-icon hidden text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @elseif($method->type === \App\Models\PaymentMethod::TYPE_CRYPTO)
                                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Network</span> <span class="text-gray-900 font-semibold">{{ $method->details['network'] ?? 'N/A' }}</span></div>
                                                        <div class="sm:col-span-2 mt-1">
                                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Wallet Address</span>
                                                            <div class="flex items-center gap-1.5 mt-1">
                                                                <span class="inline-block text-gray-950 font-mono font-bold break-all bg-gray-50 px-2.5 py-1.5 rounded border border-gray-200 select-all">{{ $method->details['wallet_address'] ?? 'N/A' }}</span>
                                                                @if(!empty($method->details['wallet_address']))
                                                                    <button type="button" onclick="copyToClipboard('{{ $method->details['wallet_address'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex-shrink-0 flex items-center justify-center" title="Copy Wallet Address">
                                                                        <svg class="w-3.5 h-3.5 copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                        </svg>
                                                                        <svg class="w-3.5 h-3.5 check-icon hidden text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @elseif($method->type === \App\Models\PaymentMethod::TYPE_ZELLE)
                                                        <div>
                                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Zelle Email / Phone</span>
                                                            <div class="flex items-center gap-1.5">
                                                                <span class="text-gray-955 font-bold select-all">{{ $method->details['email_or_phone'] ?? 'N/A' }}</span>
                                                                @if(!empty($method->details['email_or_phone']))
                                                                    <button type="button" onclick="copyToClipboard('{{ $method->details['email_or_phone'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy Zelle Information">
                                                                        <svg class="w-3.5 h-3.5 copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                        </svg>
                                                                        <svg class="w-3.5 h-3.5 check-icon hidden text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Account Name</span> <span class="text-gray-900 font-semibold">{{ $method->details['account_name'] ?? 'N/A' }}</span></div>
                                                    @elseif($method->type === \App\Models\PaymentMethod::TYPE_CASHAPP)
                                                        <div>
                                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">CashTag</span>
                                                            <div class="flex items-center gap-1.5">
                                                                <span class="text-orange-600 font-bold select-all">{{ $method->details['cashtag'] ?? 'N/A' }}</span>
                                                                @if(!empty($method->details['cashtag']))
                                                                    <button type="button" onclick="copyToClipboard('{{ $method->details['cashtag'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy CashTag">
                                                                        <svg class="w-3.5 h-3.5 copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                        </svg>
                                                                        <svg class="w-3.5 h-3.5 check-icon hidden text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @elseif($method->type === \App\Models\PaymentMethod::TYPE_PAYPAL)
                                                        <div>
                                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">PayPal Email</span>
                                                            <div class="flex items-center gap-1.5">
                                                                <span class="text-gray-955 font-bold select-all">{{ $method->details['email'] ?? 'N/A' }}</span>
                                                                @if(!empty($method->details['email']))
                                                                    <button type="button" onclick="copyToClipboard('{{ $method->details['email'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy PayPal Email">
                                                                        <svg class="w-3.5 h-3.5 copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                        </svg>
                                                                        <svg class="w-3.5 h-3.5 check-icon hidden text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @elseif($method->type === \App\Models\PaymentMethod::TYPE_MOBILE_MONEY)
                                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Provider</span> <span class="text-gray-900 font-semibold">{{ $method->details['provider'] ?? 'N/A' }}</span></div>
                                                        <div>
                                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Phone Number</span>
                                                            <div class="flex items-center gap-1.5">
                                                                <span class="text-gray-955 font-bold select-all">{{ $method->details['phone_number'] ?? 'N/A' }}</span>
                                                                @if(!empty($method->details['phone_number']))
                                                                    <button type="button" onclick="copyToClipboard('{{ $method->details['phone_number'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy Phone Number">
                                                                        <svg class="w-3.5 h-3.5 copy-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                        </svg>
                                                                        <svg class="w-3.5 h-3.5 check-icon hidden text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="sm:col-span-2 mt-1"><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Account Name</span> <span class="text-gray-900 font-semibold">{{ $method->details['account_name'] ?? 'N/A' }}</span></div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Instructions Block --}}
                                        @if(!empty($method->instructions))
                                            <div class="border-t border-orange-100/60 pt-4">
                                                <h4 class="font-bold text-gray-900 mb-2">Instructions</h4>
                                                <div class="prose prose-sm prose-orange max-w-none text-gray-600 leading-relaxed">
                                                    {!! $method->instructions !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @error('payment_method_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Upload Payment Proof</h3>
                        <p class="text-sm text-gray-500 mb-4">Please upload a screenshot or PDF of your completed payment. Accepted formats: JPG, PNG, PDF (Max 20MB).</p>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl bg-gray-50 hover:bg-gray-100 hover:border-orange-300 transition-all duration-200 cursor-pointer" onclick="document.getElementById('payment_proof').click()">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex justify-center text-sm text-gray-600">
                                    <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-semibold text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500 px-2 py-1">
                                        <span>Select a file</span>
                                        <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/jpeg,image/png,application/pdf" required>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 pt-1 font-medium" id="file-name-display">No file selected</p>
                            </div>
                        </div>

                        <!-- Live Payment Proof Preview Container -->
                        <div id="payment-proof-preview" class="mt-4 hidden p-4 border border-orange-100 bg-orange-50/10 rounded-xl">
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Selected Receipt Preview:</h4>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <!-- Image Preview -->
                                    <img id="preview-image" src="" alt="Proof Preview" class="h-20 w-20 object-cover rounded-lg border border-gray-200 hidden">
                                    
                                    <!-- PDF Icon/Placeholder -->
                                    <div id="preview-pdf" class="h-20 w-20 flex flex-col items-center justify-center bg-red-50 text-red-600 rounded-lg border border-red-100 hidden">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-[10px] font-bold mt-1">PDF</span>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 truncate max-w-[200px]" id="preview-file-name"></p>
                                        <p class="text-xs text-gray-500" id="preview-file-size"></p>
                                    </div>
                                </div>
                                
                                <button type="button" onclick="clearPaymentProof()" class="text-sm font-medium text-red-600 hover:text-red-500 transition-colors px-3 py-1.5 rounded-lg hover:bg-red-50">
                                    Remove
                                </button>
                            </div>
                        </div>
                        @error('payment_proof')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-5 mt-10 lg:mt-0 sticky top-24">
                <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-sm">
                    <h2 class="text-xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-4">Order Summary</h2>

                    <ul role="list" class="divide-y divide-gray-200 mb-6">
                        @foreach($items as $item)
                            <li class="py-4 flex gap-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-white rounded-lg border border-gray-200 overflow-hidden">
                                    @if($item['image_url'])
                                        <img src="{{ Storage::url($item['image_url']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 flex flex-col justify-center min-w-0">
                                    <div class="flex justify-between gap-2">
                                        <h3 class="text-sm font-bold text-gray-900 truncate">{{ $item['name'] }}</h3>
                                        <p class="text-sm font-bold text-gray-900 whitespace-nowrap">${{ number_format($item['line_total'], 2) }}</p>
                                    </div>
                                    <p class="text-sm text-gray-500">Qty {{ $item['quantity'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <dl class="space-y-4 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <dt>Subtotal</dt>
                            <dd class="font-medium text-gray-900">${{ number_format($subtotal, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Shipping</dt>
                            <dd class="font-medium text-gray-900">Free Shipping</dd>
                        </div>
                        <div class="border-t border-gray-200 pt-4 flex justify-between">
                            <dt class="text-base font-bold text-gray-900">Total</dt>
                            <dd class="text-xl font-extrabold text-orange-600">${{ number_format($total, 2) }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8">
                        <button type="submit" class="w-full flex items-center justify-center rounded-xl border border-transparent bg-orange-600 px-6 py-4 text-base font-bold text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-200 uppercase tracking-wide">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('payment_proof').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var fileName = file ? file.name : 'No file selected';
            document.getElementById('file-name-display').textContent = fileName;
            
            var previewContainer = document.getElementById('payment-proof-preview');
            var previewImg = document.getElementById('preview-image');
            var previewPdf = document.getElementById('preview-pdf');
            var previewName = document.getElementById('preview-file-name');
            var previewSize = document.getElementById('preview-file-size');
            
            if (file) {
                previewName.textContent = file.name;
                previewSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        previewImg.src = event.target.result;
                        previewImg.classList.remove('hidden');
                        previewPdf.classList.add('hidden');
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    previewImg.classList.add('hidden');
                    previewPdf.classList.remove('hidden');
                    previewContainer.classList.remove('hidden');
                } else {
                    previewContainer.classList.add('hidden');
                }
            } else {
                previewContainer.classList.add('hidden');
            }
        });

        function clearPaymentProof() {
            var input = document.getElementById('payment_proof');
            input.value = '';
            var event = new Event('change');
            input.dispatchEvent(event);
        }

        function copyToClipboard(text, btn) {
            if (!navigator.clipboard) {
                var textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    showCheck(btn);
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(textArea);
                return;
            }
            navigator.clipboard.writeText(text).then(function() {
                showCheck(btn);
            }, function(err) {
                console.error('Async: Could not copy text: ', err);
            });
        }

        function showCheck(btn) {
            var copyIcon = btn.querySelector('.copy-icon');
            var checkIcon = btn.querySelector('.check-icon');
            if (copyIcon && checkIcon) {
                copyIcon.classList.add('hidden');
                checkIcon.classList.remove('hidden');
                setTimeout(function() {
                    copyIcon.classList.remove('hidden');
                    checkIcon.classList.add('hidden');
                }, 2000);
            }
        }
    </script>
    @endpush
@endsection
