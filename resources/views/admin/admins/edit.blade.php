@extends('layouts.admin')

@section('title', 'Edit Admin')
@section('header', 'Edit Admin')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.admins.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to Admins
        </a>
    </div>

    <form method="POST" action="{{ route('admin.admins.update', $admin) }}">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Admin Details</h3>
                    <p class="mt-1 text-sm text-gray-500">Update information for {{ $admin->name }}.</p>
                </div>
                <a href="{{ route('admin.admins.password', $admin) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1.5 rounded-md hover:bg-indigo-100 transition-colors">
                    Change Password
                </a>
            </div>
            <div class="p-6 space-y-6">
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $admin->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Status</label>
                    <div class="mt-2 space-y-4">
                        <div class="flex items-center">
                            <input id="status_active" name="is_active" type="radio" value="1" {{ old('is_active', $admin->is_active) == '1' ? 'checked' : '' }} class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300">
                            <label for="status_active" class="ml-3 block text-sm font-medium text-gray-700">
                                Active <span class="text-gray-500 font-normal">- Can log in and manage the store.</span>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input id="status_inactive" name="is_active" type="radio" value="0" {{ old('is_active', $admin->is_active) == '0' ? 'checked' : '' }} class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300" {{ Auth::guard('admin')->id() === $admin->id ? 'disabled' : '' }}>
                            <label for="status_inactive" class="ml-3 block text-sm font-medium text-gray-700">
                                Inactive <span class="text-gray-500 font-normal">- Cannot log in.</span>
                                @if(Auth::guard('admin')->id() === $admin->id)
                                    <span class="text-red-500 text-xs italic ml-2">(You cannot deactivate yourself)</span>
                                @endif
                            </label>
                        </div>
                    </div>
                    @error('is_active')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Update Admin
                </button>
            </div>
        </div>
    </form>
@endsection
