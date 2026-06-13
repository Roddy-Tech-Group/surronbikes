@extends('layouts.storefront')

@section('meta_title', 'Frequently Asked Questions - ' . config('app.name'))
@section('meta_description', 'Find answers to common questions about our products, shipping, and ordering process.')

@section('content')
    <div class="bg-gray-900 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Frequently Asked Questions</h1>
            <p class="mt-4 text-lg text-gray-300">Everything you need to know about SuronBikes.</p>
        </div>
    </div>

    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-16">
        @if($faqs->isEmpty())
            <div class="text-center text-gray-500 py-12">No FAQs have been added yet.</div>
        @else
            <div class="space-y-4">
                @foreach($faqs as $faq)
                    <div x-data="{ expanded: false }" class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                        <button @click="expanded = !expanded" class="w-full px-6 py-4 flex justify-between items-center text-left focus:outline-none hover:bg-gray-50 transition-colors">
                            <span class="text-lg font-medium text-gray-900">{{ $faq->question }}</span>
                            <span class="ml-6 flex-shrink-0 text-gray-400">
                                <svg class="h-6 w-6 transform transition-transform duration-200" :class="{ 'rotate-180': expanded }" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="expanded" x-collapse style="display: none;">
                            <div class="px-6 pb-4 prose prose-orange max-w-none text-gray-600">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
        <div class="mt-16 text-center">
            <p class="text-base text-gray-500">Still have questions?</p>
            <a href="{{ route('contact') }}" class="mt-4 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700">
                Contact Customer Support
            </a>
        </div>
    </div>
@endsection
