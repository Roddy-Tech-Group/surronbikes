@extends('layouts.admin')

@section('title', 'Add Payment Method')
@section('header', 'Add Payment Method')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.payment-methods.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to Payment Methods
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl" 
         x-data="{ 
            type: '{{ old('type', '') }}',
            details: {{ json_encode(old('details', [])) }}
         }">
        <form action="{{ route('admin.payment-methods.store') }}" method="POST">
            @csrf

            <div class="p-6 space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Display Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. Chase Bank Transfer">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Type --}}
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Method Type <span class="text-red-500">*</span></label>
                        <select name="type" id="type" x-model="type" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                            <option value="">Select Type</option>
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <hr class="border-gray-200">

                {{-- Dynamic Details Section --}}
                <div x-show="type !== ''" x-cloak>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4" x-text="'Account Details'"></h3>
                    
                    <div class="space-y-4">
                        {{-- BANK DETAILS --}}
                        <template x-if="type === 'bank'">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Bank Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[bank_name]" :value="details.bank_name || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.bank_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Account Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[account_name]" :value="details.account_name || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.account_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Account Number <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[account_number]" :value="details.account_number || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.account_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Routing/Sort Code <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[routing_number]" :value="details.routing_number || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.routing_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </template>

                        {{-- CRYPTO DETAILS --}}
                        <template x-if="type === 'crypto'">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Network (e.g. BTC, ERC20, TRC20) <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[network]" :value="details.network || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.network')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Wallet Address <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[wallet_address]" :value="details.wallet_address || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.wallet_address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </template>

                        {{-- ZELLE DETAILS --}}
                        <template x-if="type === 'zelle'">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Zelle Email or Phone <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[email_or_phone]" :value="details.email_or_phone || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.email_or_phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Account Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[account_name]" :value="details.account_name || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.account_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </template>

                        {{-- CASHAPP DETAILS --}}
                        <template x-if="type === 'cashapp'">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">CashTag <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[cashtag]" :value="details.cashtag || ''" placeholder="$" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.cashtag')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </template>

                        {{-- PAYPAL DETAILS --}}
                        <template x-if="type === 'paypal'">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">PayPal Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="details[email]" :value="details.email || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </template>

                        {{-- MOBILE MONEY DETAILS --}}
                        <template x-if="type === 'mobile_money'">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Provider (e.g. M-Pesa, MTN) <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[provider]" :value="details.provider || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.provider')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[phone_number]" :value="details.phone_number || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.phone_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Account Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="details[account_name]" :value="details.account_name || ''" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('details.account_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </template>

                    </div>
                </div>

                {{-- Additional Instructions --}}
                <div x-show="type !== ''" x-cloak>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Additional Instructions (Optional)</label>
                    <p class="text-sm text-gray-500 mb-2">Extra notes for the customer (e.g. "Please include your Order Number in the payment memo.")</p>
                    <div class="prose max-w-none">
                        <input id="instructions" type="hidden" name="instructions" value="{{ old('instructions') }}">
                        <trix-editor input="instructions" class="trix-content min-h-[150px] bg-white border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500"></trix-editor>
                    </div>
                    @error('instructions')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Active Toggle --}}
                <div class="flex items-start pt-4">
                    <div class="flex items-center h-5">
                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_active" class="font-medium text-gray-700">Active</label>
                        <p class="text-gray-500">Allow customers to select this payment method during checkout.</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.payment-methods.index') }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Create Method
                </button>
            </div>
        </form>
    </div>
@endsection
