@extends('layouts.admin')

@section('title', 'Create FAQ')
@section('header', 'Create FAQ')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.faqs.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1.5 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to FAQs
        </a>
    </div>

    <form method="POST" action="{{ route('admin.faqs.store') }}">
        @csrf
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl">
            <div class="p-6 sm:p-8 space-y-8">
                
                <div>
                    <label for="question" class="block text-sm font-semibold text-gray-700 mb-2">Question <span class="text-red-500">*</span></label>
                    <input type="text" name="question" id="question" value="{{ old('question') }}" required maxlength="255" class="block w-full" placeholder="e.g. How do I place an order?">
                    @error('question')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="answer" class="block text-sm font-semibold text-gray-700 mb-2">Answer <span class="text-red-500">*</span></label>
                    <input id="answer" type="hidden" name="answer" value="{{ old('answer') }}">
                    <trix-editor input="answer" class="trix-content"></trix-editor>
                    @error('answer')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="w-1/3 min-w-[180px]">
                    <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-2">Sort Order <span class="text-red-500">*</span></label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $nextOrder) }}" required min="0" class="block w-full">
                    <p class="mt-2 text-sm text-gray-500">Lower numbers appear first.</p>
                    @error('sort_order')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

            </div>
            
            <div class="px-6 sm:px-8 py-5 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.faqs.index') }}" class="px-5 py-2.5 border border-gray-300 shadow-sm text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                    Save FAQ
                </button>
            </div>
        </div>
    </form>
@endsection
