@extends('layouts.admin')

@section('title', 'Edit Page: ' . $page->title)
@section('header', 'Edit Page')

{{-- Include Trix Editor dependencies --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <style>
        .trix-button-group--file-tools { display: none !important; }
        trix-editor { min-height: 400px; }
    </style>
@endpush
@push('scripts')
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        document.addEventListener("trix-file-accept", function(event) {
            event.preventDefault();
        });
    </script>
@endpush

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">{{ $page->title }}</h2>
        <p class="text-sm text-gray-500 mt-1">Manage the content and SEO metadata for the {{ $page->title }} page.</p>
    </div>

    <form method="POST" action="{{ route('admin.pages.update', $page) }}">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column (Content) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Page Content</h3>
                    </div>
                    <div class="p-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Page Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" required maxlength="255" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="mt-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                            <input id="page_content" type="hidden" name="content" value="{{ old('content', $page->content) }}">
                            <trix-editor input="page_content" class="trix-content bg-white rounded-md shadow-sm border-gray-300 focus:border-orange-500 focus:ring-orange-500 sm:text-sm"></trix-editor>
                            @error('content')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column (SEO) --}}
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.671zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59" />
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-900">SEO Settings</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->meta_title) }}" maxlength="255" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" placeholder="Optional. Replaces standard title tags.">
                            <p class="mt-1 text-xs text-gray-500">Keep under 60 characters for best results.</p>
                            @error('meta_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" placeholder="Optional. Write a brief summary of this page for search engines.">{{ old('meta_description', $page->meta_description) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Keep under 160 characters for best results.</p>
                            @error('meta_description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="w-full inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
