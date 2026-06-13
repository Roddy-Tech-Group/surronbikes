@extends('layouts.admin')

@section('title', 'Order Details: ' . $order->order_number)
@section('header', 'Order Details')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Orders
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</h1>
                @php
                    $statusColors = [
                        \App\Models\Order::STATUS_PENDING_VERIFICATION => 'bg-amber-100 text-amber-800',
                        \App\Models\Order::STATUS_PAYMENT_CONFIRMED => 'bg-blue-100 text-blue-800',
                        \App\Models\Order::STATUS_PROCESSING => 'bg-indigo-100 text-indigo-800',
                        \App\Models\Order::STATUS_SHIPPED => 'bg-purple-100 text-purple-800',
                        \App\Models\Order::STATUS_DELIVERED => 'bg-emerald-100 text-emerald-800',
                        \App\Models\Order::STATUS_CANCELLED => 'bg-red-100 text-red-800',
                    ];
                    $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                    {{ $order->status_label }}
                </span>
            </div>
            <p class="text-sm text-gray-500 mt-1">Placed on {{ $order->created_at->format('F j, Y \a\t h:i A') }}</p>
        </div>

        {{-- Action Buttons based on state --}}
        <div class="flex items-center gap-3" x-data="{ showApprove: false, showReject: false, showStatusUpdate: false }">
            
            {{-- Pending Verification Actions --}}
            @if($order->status === \App\Models\Order::STATUS_PENDING_VERIFICATION)
                <button @click.prevent.stop="showReject = true" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Reject Payment
                </button>
                <button @click.prevent.stop="showApprove = true" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Approve Payment
                </button>
            @endif

            {{-- Post-Payment Actions --}}
            @if(count($allowedTransitions) > 0 && $order->status !== \App\Models\Order::STATUS_PENDING_VERIFICATION)
                <button @click.prevent.stop="showStatusUpdate = true" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Update Order Status
                </button>
            @endif

            {{-- Modals --}}
            @include('admin.orders.partials.modals')
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column (Main Info) --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Order Items --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Order Items</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-md overflow-hidden flex items-center justify-center border border-gray-200">
                                                @if($item->product && $item->product->primaryImage)
                                                    <img class="h-12 w-12 object-cover" src="{{ Storage::url($item->product->primaryImage->path) }}" alt="">
                                                @else
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                        ${{ number_format($item->product_price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                        ${{ number_format($item->subtotal, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Subtotal</td>
                                <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">${{ number_format($order->total, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-base font-bold text-gray-900 border-t border-gray-200">Total</td>
                                <td class="px-6 py-4 text-right text-base font-bold text-gray-900 border-t border-gray-200">${{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Payment Information & Proof --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Payment Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Selected Method</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-md flex items-center justify-center bg-gray-50 border border-gray-200 p-0.5 flex-shrink-0">
                                    @if($order->paymentMethod && $order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_BANK)
                                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5M2.25 21h19.5" />
                                        </svg>
                                    @elseif($order->paymentMethod && $order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_CRYPTO)
                                        <svg class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M23.638 14.904c-1.602 6.43-8.113 10.34-14.542 8.736C2.67 22.05-1.244 15.525.362 9.105 1.962 2.67 8.475-1.243 14.9.358c6.43 1.605 10.342 8.115 8.738 14.548v-.002zm-6.35-4.613c.24-1.59-.974-2.45-2.64-3.03l.54-2.153-1.315-.33-.525 2.107c-.345-.087-.705-.167-1.064-.25l.526-2.127-1.32-.33-.54 2.165c-.285-.067-.565-.132-.84-.2l-1.815-.45-.35 1.407s.975.225.955.236c.535.136.63.486.615.766l-1.477 5.92c-.075.166-.24.406-.614.314.015.02-.96-.24-.96-.24l-.66 1.51 1.71.426.93.242-.54 2.19 1.32.327.54-2.17c.36.1.705.19 1.05.273l-.51 2.154 1.32.33.545-2.19c2.24.427 3.93.257 4.64-1.774.57-1.637-.03-2.58-1.217-3.196.854-.193 1.5-.76 1.68-1.93h.01zm-3.01 4.22c-.404 1.64-3.157.75-4.05.53l.72-2.9c.896.23 3.757.67 3.33 2.37zm.41-4.24c-.37 1.49-2.662.735-3.405.55l.654-2.64c.744.18 3.137.524 2.75 2.084v.006z"/>
                                        </svg>
                                    @elseif($order->paymentMethod && $order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_ZELLE)
                                        <svg class="w-4 h-4 text-purple-600" role="img" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M13.559 24h-2.841a.483.483 0 0 1-.483-.483v-2.765H5.638a.667.667 0 0 1-.666-.666v-2.234a.67.67 0 0 1 .142-.412l8.139-10.382h-7.25a.667.667 0 0 1-.667-.667V3.914c0-.367.299-.666.666-.666h4.23V.483c0-.266.217-.483.483-.483h2.841c.266 0 .483.217.483.483v2.765h4.323c.367 0 .666.299.666.666v2.137a.67.67 0 0 1-.141.41l-8.19 10.481h7.665c.367 0 .666.299.666.666v2.477a.667.667 0 0 1-.666.667h-4.32v2.765a.483.483 0 0 1-.483.483Z"/>
                                        </svg>
                                    @elseif($order->paymentMethod && $order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_CASHAPP)
                                        <svg class="w-4 h-4 text-emerald-500" role="img" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M23.59 3.475a5.1 5.1 0 00-3.05-3.05c-1.31-.42-2.5-.42-4.92-.42H8.36c-2.4 0-3.61 0-4.9.4a5.1 5.1 0 00-3.05 3.06C0 4.765 0 5.965 0 8.365v7.27c0 2.41 0 3.6.4 4.9a5.1 5.1 0 003.05 3.05c1.3.41 2.5.41 4.9.41h7.28c2.41 0 3.61 0 4.9-.4a5.1 5.1 0 003.06-3.06c.41-1.3.41-2.5.41-4.9v-7.25c0-2.41 0-3.61-.41-4.91zm-6.17 4.63l-.93.93a.5.5 0 01-.67.01 5 5 0 00-3.22-1.18c-.97 0-1.94.32-1.94 1.21 0 .9 1.04 1.2 2.24 1.65 2.1.7 3.84 1.58 3.84 3.64 0 2.24-1.74 3.78-4.58 3.95l-.26 1.2a.49.49 0 01-.48.39H9.63l-.09-.01a.5.5 0 01-.38-.59l.28-1.27a6.54 6.54 0 01-2.88-1.57v-.01a.48.48 0 010-.68l1-.97a.49.49 0 01.67 0c.91.86 2.13 1.32 3.39 1.32 1.3 0 2.17-.55 2.17-1.42 0-.87-.88-1.1-2.54-1.72-1.76-.63-3.43-1.52-3.43-3.6 0-2.42 2.01-3.6 4.39-3.71l.25-1.23a.48.48 0 01.48-.38h1.78l.1.01c.26.06.43.31.37.57l-.27 1.37c.9.3 1.75.77 2.48 1.39l.02.02c.19.2.19.5 0 .68z"/>
                                        </svg>
                                    @elseif($order->paymentMethod && $order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_PAYPAL)
                                        <svg class="w-4 h-4 text-blue-600" role="img" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M15.607 4.653H8.941L6.645 19.251H1.82L4.862 0h7.995c3.754 0 6.375 2.294 6.473 5.513-.648-.478-2.105-.86-3.722-.86m6.57 5.546c0 3.41-3.01 6.853-6.958 6.853h-2.493L11.595 24H6.74l1.845-11.538h3.592c4.208 0 7.346-3.634 7.153-6.949a5.24 5.24 0 0 1 2.848 4.686M9.653 5.546h6.408c.907 0 1.942.222 2.363.541-.195 2.741-2.655 5.483-6.441 5.483H8.714Z"/>
                                        </svg>
                                    @elseif($order->paymentMethod && $order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_MOBILE_MONEY)
                                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                        </svg>
                                    @endif
                                </span>
                                {{ $order->paymentMethod->name ?? 'Unknown' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if(in_array($order->status, [\App\Models\Order::STATUS_PENDING_VERIFICATION, \App\Models\Order::STATUS_CANCELLED]))
                                    <span class="text-amber-600 font-medium">Awaiting Approval</span>
                                @else
                                    <span class="text-emerald-600 font-medium">Confirmed</span>
                                @endif
                            </dd>
                        </div>

                        @if($order->paymentMethod && !empty($order->paymentMethod->details))
                            <div class="sm:col-span-2 border-t border-gray-100 pt-4">
                                <dt class="text-sm font-medium text-gray-500 mb-2">Method Account Details</dt>
                                <dd class="bg-gray-50 rounded-lg p-4 border border-gray-200 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 font-medium text-gray-700">
                                    @if($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_BANK)
                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Bank Name</span> <span class="text-gray-900 font-semibold">{{ $order->paymentMethod->details['bank_name'] ?? 'N/A' }}</span></div>
                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Account Name</span> <span class="text-gray-900 font-semibold">{{ $order->paymentMethod->details['account_name'] ?? 'N/A' }}</span></div>
                                        <div>
                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Account Number</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-gray-955 font-mono font-bold select-all">{{ $order->paymentMethod->details['account_number'] ?? 'N/A' }}</span>
                                                @if(!empty($order->paymentMethod->details['account_number']))
                                                    <button type="button" onclick="copyToClipboard('{{ $order->paymentMethod->details['account_number'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy Account Number">
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
                                                <span class="text-gray-900 font-mono select-all">{{ $order->paymentMethod->details['routing_number'] ?? 'N/A' }}</span>
                                                @if(!empty($order->paymentMethod->details['routing_number']))
                                                    <button type="button" onclick="copyToClipboard('{{ $order->paymentMethod->details['routing_number'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy Routing Code">
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
                                    @elseif($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_CRYPTO)
                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Network</span> <span class="text-gray-900 font-semibold">{{ $order->paymentMethod->details['network'] ?? 'N/A' }}</span></div>
                                        <div>
                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Wallet Address</span>
                                            <div class="flex items-center gap-1.5 mt-1">
                                                <span class="inline-block text-gray-955 font-mono font-bold break-all bg-white px-2 py-1 rounded border border-gray-200 select-all">{{ $order->paymentMethod->details['wallet_address'] ?? 'N/A' }}</span>
                                                @if(!empty($order->paymentMethod->details['wallet_address']))
                                                    <button type="button" onclick="copyToClipboard('{{ $order->paymentMethod->details['wallet_address'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex-shrink-0 flex items-center justify-center" title="Copy Wallet Address">
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
                                    @elseif($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_ZELLE)
                                        <div>
                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Zelle Email / Phone</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-gray-955 font-bold select-all">{{ $order->paymentMethod->details['email_or_phone'] ?? 'N/A' }}</span>
                                                @if(!empty($order->paymentMethod->details['email_or_phone']))
                                                    <button type="button" onclick="copyToClipboard('{{ $order->paymentMethod->details['email_or_phone'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy Zelle Information">
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
                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Account Name</span> <span class="text-gray-900 font-semibold">{{ $order->paymentMethod->details['account_name'] ?? 'N/A' }}</span></div>
                                    @elseif($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_CASHAPP)
                                        <div>
                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">CashTag</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-orange-600 font-bold select-all">{{ $order->paymentMethod->details['cashtag'] ?? 'N/A' }}</span>
                                                @if(!empty($order->paymentMethod->details['cashtag']))
                                                    <button type="button" onclick="copyToClipboard('{{ $order->paymentMethod->details['cashtag'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy CashTag">
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
                                    @elseif($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_PAYPAL)
                                        <div>
                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">PayPal Email</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-gray-955 font-bold select-all">{{ $order->paymentMethod->details['email'] ?? 'N/A' }}</span>
                                                @if(!empty($order->paymentMethod->details['email']))
                                                    <button type="button" onclick="copyToClipboard('{{ $order->paymentMethod->details['email'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy PayPal Email">
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
                                    @elseif($order->paymentMethod->type === \App\Models\PaymentMethod::TYPE_MOBILE_MONEY)
                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Provider</span> <span class="text-gray-900 font-semibold">{{ $order->paymentMethod->details['provider'] ?? 'N/A' }}</span></div>
                                        <div>
                                            <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Phone Number</span>
                                            <div class="flex items-center gap-1.5">
                                                <span class="text-gray-955 font-bold select-all">{{ $order->paymentMethod->details['phone_number'] ?? 'N/A' }}</span>
                                                @if(!empty($order->paymentMethod->details['phone_number']))
                                                    <button type="button" onclick="copyToClipboard('{{ $order->paymentMethod->details['phone_number'] }}', this)" class="text-gray-400 hover:text-orange-600 transition-colors p-1 rounded hover:bg-gray-100 flex items-center justify-center" title="Copy Phone Number">
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
                                        <div><span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider mb-0.5">Account Name</span> <span class="text-gray-900 font-semibold">{{ $order->paymentMethod->details['account_name'] ?? 'N/A' }}</span></div>
                                    @endif
                                </dd>
                            </div>
                        @endif
                        
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Uploaded Payment Proof</dt>
                            <dd class="mt-1">
                                @if($order->payment_proof_path)
                                    @php
                                        $ext = strtolower(pathinfo($order->payment_proof_path, PATHINFO_EXTENSION));
                                        $isImage = in_array($ext, ['jpg','jpeg','png','webp']);
                                        $isPdf = $ext === 'pdf';
                                    @endphp
                                    <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50 shadow-sm mt-2">
                                        @if($isImage)
                                            <div class="w-full bg-gray-100 flex items-center justify-center border-b border-gray-200" style="max-height: 500px; overflow: hidden;">
                                                <a href="{{ Storage::url($order->payment_proof_path) }}" target="_blank" title="Click to view full size" class="w-full flex justify-center">
                                                    <img src="{{ Storage::url($order->payment_proof_path) }}" alt="Payment Proof" class="w-full h-auto object-contain" style="max-height: 500px;">
                                                </a>
                                            </div>
                                        @elseif($isPdf)
                                            <div class="w-full bg-gray-100 flex items-center justify-center border-b border-gray-200 h-96">
                                                <iframe src="{{ Storage::url($order->payment_proof_path) }}" class="w-full h-full border-0"></iframe>
                                            </div>
                                        @endif
                                        <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            <div class="flex items-center">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                                <div class="ml-3 text-sm">
                                                    <span class="font-medium text-gray-900">Payment Proof Document</span>
                                                    <p class="text-gray-500 text-xs mt-0.5">Uploaded by customer</p>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                @if($isImage || $isPdf)
                                                    <a href="{{ Storage::url($order->payment_proof_path) }}" target="_blank" class="px-3 py-1.5 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                                        Open Full Size
                                                    </a>
                                                @endif
                                                <a href="{{ route('admin.orders.download-proof', $order) }}" class="px-3 py-1.5 bg-indigo-50 border border-indigo-200 rounded-md text-sm font-medium text-indigo-700 hover:bg-indigo-100 transition-colors">
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-sm text-amber-600 bg-amber-50 p-4 rounded-lg border border-amber-200">
                                        No payment proof has been uploaded for this order yet.
                                    </div>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

        </div>

        {{-- Right Column (Sidebar) --}}
        <div class="space-y-8">
            
            {{-- Customer Information --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Customer Details</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4 text-sm">
                        <div>
                            <dt class="font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 font-medium text-gray-900">{{ $order->customer_name }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-gray-900"><a href="mailto:{{ $order->customer_email }}" class="text-indigo-600 hover:underline">{{ $order->customer_email }}</a></dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Phone Number</dt>
                            <dd class="mt-1 text-gray-900"><a href="tel:{{ $order->customer_phone }}" class="text-indigo-600 hover:underline">{{ $order->customer_phone }}</a></dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Shipping Address</h3>
                </div>
                <div class="p-6">
                    <address class="not-italic text-sm text-gray-900 space-y-1">
                        <p class="font-medium">{{ $order->customer_name }}</p>
                        <p>{{ $order->shipping_address }}</p>
                        <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                        <p>{{ $order->shipping_country }}</p>
                    </address>
                </div>
            </div>

            {{-- Order Timeline --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900">Order Timeline</h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            {{-- Placed Order Step --}}
                            <li>
                                <div class="relative pb-8">
                                    @if($order->statusHistories->isNotEmpty())
                                        <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-500">Order placed by <span class="font-medium text-gray-900">Customer</span></p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                <time datetime="{{ $order->created_at }}">{{ $order->created_at->format('M d, H:i') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            {{-- Audit History Steps --}}
                            @foreach($order->statusHistories->reverse() as $history)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                @php
                                                    $iconColor = match($history->new_status) {
                                                        \App\Models\Order::STATUS_PAYMENT_CONFIRMED => 'bg-blue-500',
                                                        \App\Models\Order::STATUS_PROCESSING => 'bg-indigo-500',
                                                        \App\Models\Order::STATUS_SHIPPED => 'bg-purple-500',
                                                        \App\Models\Order::STATUS_DELIVERED => 'bg-emerald-500',
                                                        \App\Models\Order::STATUS_CANCELLED => 'bg-red-500',
                                                        default => 'bg-gray-500'
                                                    };
                                                @endphp
                                                <span class="h-8 w-8 rounded-full {{ $iconColor }} flex items-center justify-center ring-8 ring-white">
                                                    @if($history->new_status === \App\Models\Order::STATUS_CANCELLED)
                                                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    @elseif($history->new_status === \App\Models\Order::STATUS_DELIVERED)
                                                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                    @else
                                                        <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">Status changed to <span class="font-medium text-gray-900">{{ \App\Models\Order::STATUSES[$history->new_status] ?? $history->new_status }}</span></p>
                                                    @if($history->admin)
                                                        <p class="text-xs text-gray-400 mt-0.5">by {{ $history->admin->name }}</p>
                                                    @endif
                                                    @if($history->reason)
                                                        <p class="text-xs text-red-600 mt-1 italic">"{{ $history->reason }}"</p>
                                                    @endif
                                                </div>
                                                <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                    <time datetime="{{ $history->created_at }}">{{ $history->created_at->format('M d, H:i') }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
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
