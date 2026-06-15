@extends('layouts.storefront')

@section('meta_title', 'Contact Us - ' . config('app.name'))
@section('meta_description', 'Get in touch with the SuronBikes team for inquiries, support, or sales questions.')

@section('content')
    <div class="bg-gray-900 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">Contact Us</h1>
            <p class="mt-4 text-lg text-gray-300">We're here to help. Send us a message and we'll respond as soon as possible.</p>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-3xl mx-auto mb-20">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900">Get In Touch</h2>
                <div class="mt-4 w-16 h-1 bg-orange-500 mx-auto rounded-full"></div>
            </div>

            {{-- Contact Form --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 p-8 md:p-12">
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 bg-gray-50 py-3 px-4">
                            @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 bg-gray-50 py-3 px-4">
                            @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                        @php
                            $defaultSubject = request('subject', old('subject'));
                        @endphp
                        <input type="text" name="subject" id="subject" value="{{ $defaultSubject }}" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 bg-gray-50 py-3 px-4">
                        @error('subject')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                        <textarea name="message" id="message" rows="6" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 bg-gray-50 py-3 px-4">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="w-full flex justify-center py-4 px-8 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-transform hover:-translate-y-0.5">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        {{-- Contact Information (Displayed Below) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 pt-16 border-t border-gray-200">
            @if(!empty($globalSettings['company_email']))
                <div class="text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-6 shadow-sm">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Email Us</h3>
                    <p class="text-gray-500 mb-4">For general inquiries and support.</p>
                    <a href="mailto:{{ $globalSettings['company_email'] }}" class="text-orange-600 hover:text-orange-700 font-bold text-lg">{{ $globalSettings['company_email'] }}</a>
                </div>
            @endif

            @if(!empty($globalSettings['company_phone']))
                <div class="text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 shadow-sm">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Call Us</h3>
                    <p class="text-gray-500 mb-4">Mon-Fri from 8am to 5pm.</p>
                    <p class="text-gray-900 font-bold text-lg">{{ $globalSettings['company_phone'] }}</p>
                </div>
            @endif

            @if(!empty($globalSettings['company_address']))
                <div class="text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 shadow-sm">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Headquarters</h3>
                    <p class="text-gray-500 font-medium leading-relaxed max-w-[250px] mx-auto">{!! nl2br(e($globalSettings['company_address'])) !!}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
