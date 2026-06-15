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
        
        <div class="max-w-4xl space-y-6">
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

            <div class="flex justify-end">
                <button type="submit" class="w-full sm:w-auto inline-flex justify-center py-2.5 px-8 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Save Changes
                </button>
            </div>
        </div>
    </form>
@endsection
