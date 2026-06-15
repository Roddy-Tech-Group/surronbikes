@extends('layouts.admin')

@section('title', 'Add Testimonial')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Add Testimonial</h1>
    </div>
    <a href="{{ route('admin.testimonials.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">&larr; Back to Testimonials</a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 divide-y divide-gray-200 p-6 sm:p-8">
        @csrf

        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                    <div class="mt-1">
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" required>
                    </div>
                    @error('customer_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role / Subtitle</label>
                    <div class="mt-1">
                        <input type="text" name="role" id="role" value="{{ old('role') }}" placeholder="e.g. Verified Buyer" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                    </div>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-6">
                    <label for="content" class="block text-sm font-medium text-gray-700">Testimonial Content</label>
                    <div class="mt-1">
                        <textarea id="content" name="content" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" required>{{ old('content') }}</textarea>
                    </div>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1-5)</label>
                    <div class="mt-1">
                        <select id="rating" name="rating" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>{{ $i }} Stars</option>
                            @endfor
                        </select>
                    </div>
                    @error('rating')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="image" class="block text-sm font-medium text-gray-700">Customer Image (Optional)</label>
                    <div class="mt-1">
                        <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                    </div>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-6">
                    <div class="relative flex items-start">
                        <div class="flex h-5 items-center">
                            <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_active" class="font-medium text-gray-700">Active</label>
                            <p class="text-gray-500">Display this testimonial on the storefront.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <a href="{{ route('admin.testimonials.index') }}" class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">Cancel</a>
                <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-orange-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection
