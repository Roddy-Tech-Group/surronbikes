@extends('layouts.admin')

@section('title', 'Orders')
@section('header', 'Orders')

@section('content')
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <p class="text-sm text-gray-500 mt-1">Manage all customer orders and their current fulfillment status.</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white p-4 rounded-t-xl border border-gray-200 border-b-0">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col lg:flex-row lg:items-center flex-wrap gap-4">
            {{-- Keep the global search term if present --}}
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            
            {{-- Status --}}
            <div class="w-full sm:w-56">
                <select name="status" class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-lg" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    @foreach(\App\Models\Order::STATUSES as $key => $label)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Date Range --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 w-full lg:w-auto">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="block w-full sm:w-auto py-2 px-3 border border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500 text-gray-600" onchange="this.form.submit()">
                <span class="text-gray-400 hidden sm:inline">to</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="block w-full sm:w-auto py-2 px-3 border border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500 text-gray-600" onchange="this.form.submit()">
            </div>
            
            @if(request()->anyFilled(['search', 'status', 'date_from', 'date_to']))
                <div class="w-full lg:w-auto">
                    <a href="{{ route('admin.orders.index') }}" class="inline-flex w-full sm:w-auto justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                        Clear Filters
                    </a>
                </div>
            @endif
        </form>
    </div>

    <div class="bg-white border border-gray-200 rounded-b-xl shadow-sm overflow-hidden">
        @if($orders->isEmpty())
            <div class="px-6 py-16 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900">No orders found</h3>
                <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">
                    @if(request()->anyFilled(['search', 'status', 'date_from', 'date_to']))
                        No orders matched your applied filters.
                    @else
                        You have not received any customer orders yet.
                    @endif
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $order->order_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->customer_email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ $order->formatted_total }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->paymentMethod->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold bg-indigo-50 px-3 py-1 rounded-md hover:bg-indigo-100 transition-colors">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($orders->hasPages())
                <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
