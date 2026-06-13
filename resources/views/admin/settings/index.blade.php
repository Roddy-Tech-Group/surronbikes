@extends('layouts.admin')

@section('title', 'Settings')
@section('header', 'Business Settings')

@section('content')
    <div class="mb-8">
        <p class="text-sm text-gray-500 mt-1">Manage your company information, branding, and social media links. These details are used across the website and email templates.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8 max-w-4xl">
        @csrf
        @method('PUT')

        {{-- Company Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 sm:px-8 py-5 border-b border-gray-200 bg-gray-50/80">
                <h3 class="text-base font-bold text-gray-900 flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>
                    Company Information
                </h3>
            </div>
            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-2">Company Name</label>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $settings['company_name'] ?? '') }}">
                    @error('company_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="company_email" class="block text-sm font-semibold text-gray-700 mb-2">Support Email</label>
                    <input type="email" name="company_email" id="company_email" value="{{ old('company_email', $settings['company_email'] ?? '') }}">
                    @error('company_email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="company_phone" class="block text-sm font-semibold text-gray-700 mb-2">Contact Phone</label>
                    <input type="text" name="company_phone" id="company_phone" value="{{ old('company_phone', $settings['company_phone'] ?? '') }}">
                    @error('company_phone')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="company_address" class="block text-sm font-semibold text-gray-700 mb-2">Physical Address</label>
                    <textarea name="company_address" id="company_address" rows="3">{{ old('company_address', $settings['company_address'] ?? '') }}</textarea>
                    @error('company_address')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Branding --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 sm:px-8 py-5 border-b border-gray-200 bg-gray-50/80">
                <h3 class="text-base font-bold text-gray-900 flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-gradient-to-br from-violet-50 to-violet-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                        </svg>
                    </div>
                    Branding
                </h3>
            </div>
            <div class="p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row gap-6 items-start" x-data="{ 
                    previewUrl: '{{ isset($settings['logo_path']) ? Storage::url($settings['logo_path']) : '' }}',
                    fileChosen(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.previewUrl = URL.createObjectURL(file);
                        }
                    }
                }">
                    <div class="w-full sm:w-1/3">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Company Logo</label>
                        <div class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                            <template x-if="previewUrl">
                                <img :src="previewUrl" class="max-h-32 object-contain mb-4" alt="Logo Preview">
                            </template>
                            <template x-if="!previewUrl">
                                <div class="h-32 flex items-center justify-center text-gray-400 mb-4">
                                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            </template>
                            
                            <label class="relative cursor-pointer bg-white py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm leading-4 font-semibold text-gray-700 hover:bg-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500 transition-colors">
                                <span>Upload a file</span>
                                <input type="file" name="logo" class="sr-only" @change="fileChosen" accept="image/png, image/jpeg, image/webp, image/svg+xml">
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">PNG, JPG, WEBP, or SVG up to 2MB.</p>
                        @error('logo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

                        @if(isset($settings['logo_path']))
                            <div class="mt-3 flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="delete_logo" name="delete_logo" type="checkbox" value="1" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="delete_logo" class="font-medium text-red-700">Remove existing logo</label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Social Links --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 sm:px-8 py-5 border-b border-gray-200 bg-gray-50/80">
                <h3 class="text-base font-bold text-gray-900 flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                        </svg>
                    </div>
                    Social Links
                </h3>
            </div>
            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="social_facebook" class="block text-sm font-semibold text-gray-700 mb-2">Facebook URL</label>
                    <input type="url" name="social_facebook" id="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}" placeholder="https://facebook.com/...">
                    @error('social_facebook')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="social_instagram" class="block text-sm font-semibold text-gray-700 mb-2">Instagram URL</label>
                    <input type="url" name="social_instagram" id="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" placeholder="https://instagram.com/...">
                    @error('social_instagram')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="social_tiktok" class="block text-sm font-semibold text-gray-700 mb-2">TikTok URL</label>
                    <input type="url" name="social_tiktok" id="social_tiktok" value="{{ old('social_tiktok', $settings['social_tiktok'] ?? '') }}" placeholder="https://tiktok.com/@...">
                    @error('social_tiktok')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="social_youtube" class="block text-sm font-semibold text-gray-700 mb-2">YouTube URL</label>
                    <input type="url" name="social_youtube" id="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" placeholder="https://youtube.com/...">
                    @error('social_youtube')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="social_twitter" class="block text-sm font-semibold text-gray-700 mb-2">Twitter/X URL</label>
                    <input type="url" name="social_twitter" id="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}" placeholder="https://x.com/...">
                    @error('social_twitter')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="px-6 py-3 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                Save Settings
            </button>
        </div>
    </form>
@endsection
