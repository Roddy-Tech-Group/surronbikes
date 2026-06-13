@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-10">
        {{-- Total Orders --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 tracking-wide">Total Orders</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2 tracking-tight">{{ number_format($stats['total_orders']) }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 tracking-wide">Pending Orders</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2 tracking-tight">{{ number_format($stats['pending_orders']) }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 tracking-wide">Revenue</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2 tracking-tight">${{ number_format($stats['revenue'], 2) }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Products --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 tracking-wide">Products</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2 tracking-tight">{{ number_format($stats['total_products']) }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-violet-50 to-violet-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-violet-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-orange-600 hover:text-orange-500 transition-colors">View all &rarr;</a>
        </div>

        @if($recentOrders->isEmpty())
            <div class="px-6 py-16 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900">No orders yet</h3>
                <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">Orders will appear here once customers start placing them.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/80">
                            <th class="px-6 py-3.5 text-left font-semibold text-gray-500 uppercase tracking-wider text-xs">Order #</th>
                            <th class="px-6 py-3.5 text-left font-semibold text-gray-500 uppercase tracking-wider text-xs">Customer</th>
                            <th class="px-6 py-3.5 text-left font-semibold text-gray-500 uppercase tracking-wider text-xs">Total</th>
                            <th class="px-6 py-3.5 text-left font-semibold text-gray-500 uppercase tracking-wider text-xs">Status</th>
                            <th class="px-6 py-3.5 text-left font-semibold text-gray-500 uppercase tracking-wider text-xs">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-gray-50/50 transition-colors duration-100">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $order->customer_name }}</td>
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $order->formatted_total }}</td>
                                <td class="px-6 py-4">
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
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
