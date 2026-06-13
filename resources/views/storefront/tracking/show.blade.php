@extends('layouts.storefront')

@section('meta_title', 'Order Details - ' . $order->order_number)

@section('content')
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Order {{ $order->order_number }}</h1>
                <p class="mt-2 text-sm text-gray-500">Placed on <time datetime="{{ $order->created_at->format('Y-m-d') }}">{{ $order->created_at->format('M d, Y') }}</time></p>
            </div>
            <div>
                <a href="{{ route('tracking.index') }}" class="text-sm font-medium text-orange-600 hover:text-orange-500 flex items-center gap-1.5 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Track another order
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        
        @if($order->status === \App\Models\Order::STATUS_CANCELLED)
            <div class="rounded-2xl bg-red-50 border border-red-100 p-6 mb-12">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-base font-bold text-red-800">Order Cancelled</h3>
                        <div class="mt-1 text-sm text-red-700">
                            <p>This order has been cancelled. If you believe this is an error, please contact support.</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Order Timeline --}}
            @php
                $stages = [
                    \App\Models\Order::STATUS_PENDING_VERIFICATION => ['label' => 'Payment Pending', 'desc' => 'We are waiting for your payment verification.'],
                    \App\Models\Order::STATUS_PAYMENT_CONFIRMED => ['label' => 'Payment Confirmed', 'desc' => 'Your payment has been verified.'],
                    \App\Models\Order::STATUS_PROCESSING => ['label' => 'Processing', 'desc' => 'Your order is being prepared.'],
                    \App\Models\Order::STATUS_SHIPPED => ['label' => 'Shipped', 'desc' => 'Your order is on its way!'],
                    \App\Models\Order::STATUS_DELIVERED => ['label' => 'Delivered', 'desc' => 'Your order has been delivered.']
                ];
                
                $currentStageIndex = array_search($order->status, array_keys($stages));
            @endphp
            
            <div class="mb-16">
                <h2 class="text-lg font-bold text-gray-900 mb-8">Tracking Status</h2>
                
                {{-- Desktop: horizontal timeline --}}
                <div class="hidden sm:block relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full h-1 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-orange-500 rounded-full transition-all duration-700" style="width: {{ $currentStageIndex !== false ? ($currentStageIndex / (count($stages) - 1)) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="relative flex justify-between">
                        @php $index = 0; @endphp
                        @foreach($stages as $key => $stage)
                            @php
                                $isCompleted = $index <= $currentStageIndex;
                                $isCurrent = $index === $currentStageIndex;
                            @endphp
                            
                            <div class="flex flex-col items-center">
                                <div class="h-12 w-12 rounded-full {{ $isCompleted ? 'bg-orange-600 shadow-lg' : 'bg-white border-2 border-gray-200' }} flex items-center justify-center relative z-10 transition-all duration-300 {{ $isCurrent ? 'animate-status-pulse ring-4 ring-orange-100' : '' }}">
                                    @if($isCompleted)
                                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    @else
                                        <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                                    @endif
                                </div>
                                <span class="mt-3 text-sm font-semibold {{ $isCurrent ? 'text-orange-600' : ($isCompleted ? 'text-gray-900' : 'text-gray-400') }} text-center max-w-[120px]">
                                    {{ $stage['label'] }}
                                </span>
                            </div>
                            
                            @php $index++; @endphp
                        @endforeach
                    </div>
                </div>

                {{-- Mobile: vertical timeline --}}
                <div class="sm:hidden">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @php $index = 0; @endphp
                            @foreach($stages as $key => $stage)
                                @php
                                    $isCompleted = $index <= $currentStageIndex;
                                    $isCurrent = $index === $currentStageIndex;
                                @endphp
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 {{ $index < $currentStageIndex ? 'bg-orange-500' : 'bg-gray-200' }}" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex items-start space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full {{ $isCompleted ? 'bg-orange-600' : 'bg-white border-2 border-gray-200' }} flex items-center justify-center {{ $isCurrent ? 'animate-status-pulse ring-4 ring-orange-100' : '' }}">
                                                    @if($isCompleted)
                                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                                    @else
                                                        <div class="w-2.5 h-2.5 bg-gray-300 rounded-full"></div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <p class="text-sm font-bold {{ $isCurrent ? 'text-orange-600' : ($isCompleted ? 'text-gray-900' : 'text-gray-400') }}">{{ $stage['label'] }}</p>
                                                <p class="mt-0.5 text-xs {{ $isCompleted ? 'text-gray-500' : 'text-gray-400' }}">{{ $stage['desc'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @php $index++; @endphp
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Products --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gray-50/80">
                        <h3 class="text-lg font-bold text-gray-900">Items Ordered</h3>
                    </div>
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <li class="p-6 flex">
                                <div class="ml-4 flex-1 flex flex-col justify-center min-w-0">
                                    <div class="flex justify-between gap-4">
                                        <h4 class="font-bold text-gray-900 truncate">{{ $item->product_name }}</h4>
                                        <p class="font-bold text-gray-900 whitespace-nowrap">${{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Qty {{ $item->quantity }} @ ${{ number_format($item->product_price, 2) }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="px-6 py-5 border-t border-gray-200 bg-gray-50/80 flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900">Total</span>
                        <span class="text-xl font-extrabold text-orange-600">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

            </div>

            <div class="space-y-8">

                {{-- Shipping Info --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gray-50/80">
                        <h3 class="text-lg font-bold text-gray-900">Shipping Details</h3>
                    </div>
                    <div class="p-6 text-sm text-gray-600 space-y-5">
                        <div>
                            <span class="block font-semibold text-gray-900 mb-1.5">Customer</span>
                            {{ $order->customer_name }}<br>
                            {{ $order->customer_email }}<br>
                            {{ $order->customer_phone }}
                        </div>
                        <div>
                            <span class="block font-semibold text-gray-900 mb-1.5">Address</span>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                            {{ $order->shipping_country }}
                        </div>
                        
                        @if($order->tracking_number)
                            <div class="pt-4 border-t border-gray-100">
                                <span class="block font-semibold text-gray-900 mb-1.5">Tracking Information</span>
                                <span class="text-orange-600 font-bold">{{ $order->carrier ?? 'Carrier' }}: {{ $order->tracking_number }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
