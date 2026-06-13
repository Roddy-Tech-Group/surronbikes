@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        {{-- Total Orders --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_orders']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending Orders</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['pending_orders']) }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($stats['revenue'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Products</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_products']) }}</p>
                </div>
                <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-violet-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-gray-900">Recent Orders</h2>
        </div>

        @if($recentOrders->isEmpty())
            <div class="px-5 py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <p class="text-sm text-gray-500 font-medium">No orders yet</p>
                <p class="text-xs text-gray-400 mt-1">Orders will appear here once customers start placing them.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-5 py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Order #</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Customer</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Total</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Status</th>
                            <th class="px-5 py-3 text-left font-medium text-gray-500 uppercase tracking-wider text-xs">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition-colors duration-100">
                                <td class="px-5 py-3 font-medium text-gray-900">{{ $order->order_number }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $order->customer_name }}</td>
                                <td class="px-5 py-3 font-medium text-gray-900">{{ $order->formatted_total }}</td>
                                <td class="px-5 py-3">
                                    @php
                                        $statusColors = [
                                            'pending_verification' => 'bg-amber-100 text-amber-700',
                                            'payment_confirmed' => 'bg-blue-100 text-blue-700',
                                            'processing' => 'bg-indigo-100 text-indigo-700',
                                            'shipped' => 'bg-purple-100 text-purple-700',
                                            'delivered' => 'bg-emerald-100 text-emerald-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                        $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
