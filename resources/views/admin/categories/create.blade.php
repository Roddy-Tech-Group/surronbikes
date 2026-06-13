@extends('layouts.admin')

@section('title', 'Add Category')
@section('header', 'Add Category')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to Categories
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-2xl">
        <form action="{{ route('admin.categories.store') }}" method="POST" x-data="{ name: '{{ old('name') }}', slug: '{{ old('slug') }}' }">
            @csrf

            <div class="p-6 space-y-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" x-model="name" required class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" placeholder="e.g. Surron Bikes">
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug (Optional) --}}
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                    <div class="mt-1">
                        <input type="text" name="slug" id="slug" x-model="slug" class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md @error('slug') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" placeholder="Auto-generated if left blank">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Leave blank to automatically generate from the name: 
                        <span class="font-mono text-gray-700" x-text="name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '') || 'auto-generated-slug'"></span>
                    </p>
                    @error('slug')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Create Category
                </button>
            </div>
        </form>
    </div>
@endsection
