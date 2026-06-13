<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('meta_title', config('app.name', 'SuronBikes'))</title>
    <meta name="description" content="@yield('meta_description', 'Premium Electric Bikes & Powersports')">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false, mobileSearchOpen: false }">

    {{-- Sticky Header --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                {{-- Logo --}}
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        @if(!empty($globalSettings['logo_path']))
                            <img src="{{ Storage::url($globalSettings['logo_path']) }}" alt="{{ $globalSettings['company_name'] ?? 'Logo' }}" class="h-10 w-auto">
                        @else
                            <div class="w-10 h-10 bg-orange-600 rounded-xl flex items-center justify-center font-bold text-white text-lg group-hover:bg-orange-700 transition-colors">SB</div>
                            <span class="font-bold text-xl tracking-tight">{{ $globalSettings['company_name'] ?? 'SuronBikes' }}</span>
                        @endif
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">Shop</a>
                    
                    {{-- Categories Dropdown --}}
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button type="button" class="text-gray-700 hover:text-orange-600 font-medium transition-colors flex items-center gap-1">
                            Categories
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open" x-transition.opacity class="absolute z-10 -ml-4 mt-0 pt-4 w-56">
                            <div class="rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 bg-white py-2 overflow-hidden border border-gray-100">
                                @foreach($globalCategories as $category)
                                    <a href="{{ route('home', ['category' => $category->slug]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('page.show', 'about-us') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">About</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">Contact</a>
                </nav>

                {{-- Right Actions --}}
                <div class="flex items-center gap-4">
                    {{-- Search Form --}}
                    <form action="{{ route('home') }}" method="GET" class="hidden sm:block relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-64 pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm bg-gray-50">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </form>

                    {{-- Mobile Search Icon --}}
                    <button @click="mobileSearchOpen = !mobileSearchOpen; if(mobileSearchOpen) $nextTick(() => $refs.mobileSearchInput.focus()); mobileMenuOpen = false;" class="sm:hidden p-2 text-gray-700 hover:text-orange-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>

                    {{-- Cart Icon --}}
                    @inject('cartService', 'App\Services\CartService')
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-orange-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        @if($cartService->getCount() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-orange-600 rounded-full">
                                {{ $cartService->getCount() }}
                            </span>
                        @endif
                    </a>

                    {{-- Mobile menu button --}}
                    <button @click="mobileMenuOpen = !mobileMenuOpen; mobileSearchOpen = false;" class="md:hidden p-2 text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Search Dropdown --}}
        <div x-show="mobileSearchOpen" x-transition.opacity class="sm:hidden border-t border-gray-100 bg-white px-4 py-3 shadow-md" style="display: none;" @click.away="mobileSearchOpen = false">
            <form action="{{ route('home') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm bg-gray-50" x-ref="mobileSearchInput">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </form>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenuOpen" class="md:hidden border-t border-gray-200 bg-white shadow-md" style="display: none;" @click.away="mobileMenuOpen = false">
            <div class="px-4 pt-4 pb-4 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Shop</a>
                
                <div class="pl-4 py-2 border-l-2 border-gray-100 space-y-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Categories</span>
                    @foreach($globalCategories as $category)
                        <a href="{{ route('home', ['category' => $category->slug]) }}" class="block text-sm font-medium text-gray-600 hover:text-orange-600">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
                
                <a href="{{ route('page.show', 'about-us') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">About Us</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Contact</a>
                <a href="{{ route('faq') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">FAQ</a>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-grow">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-emerald-600 text-white px-4 py-3 text-center text-sm font-medium" x-data="{ show: true }" x-show="show">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="text-white hover:text-emerald-200"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-600 text-white px-4 py-3 text-center text-sm font-medium" x-data="{ show: true }" x-show="show">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <span>{{ session('error') }}</span>
                    <button @click="show = false" class="text-white hover:text-red-200"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white pt-16 pb-8 border-t border-gray-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-12 mb-12">
                {{-- Brand Info --}}
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center font-bold text-white text-sm">SB</div>
                        <span class="font-bold text-xl tracking-tight">{{ $globalSettings['company_name'] ?? 'SuronBikes' }}</span>
                    </div>
                    <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                        Premium electric bikes and powersports equipment. Delivered securely, ready to ride.
                    </p>
                    <div class="flex space-x-4">
                        @if(!empty($globalSettings['social_facebook']))
                            <a href="{{ $globalSettings['social_facebook'] }}" target="_blank" class="text-gray-400 hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg></a>
                        @endif
                        @if(!empty($globalSettings['social_instagram']))
                            <a href="{{ $globalSettings['social_instagram'] }}" target="_blank" class="text-gray-400 hover:text-white"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg></a>
                        @endif
                    </div>
                </div>

                {{-- Categories --}}
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Shop By Category</h3>
                    <ul class="space-y-3">
                        @foreach($globalCategories as $category)
                            <li><a href="{{ route('home', ['category' => $category->slug]) }}" class="text-gray-400 hover:text-white transition-colors text-sm">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Legal Pages --}}
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Support & Legal</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('faq') }}" class="text-gray-400 hover:text-white transition-colors text-sm">FAQ</a></li>
                        <li><a href="{{ route('page.show', 'shipping-policy') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Shipping Policy</a></li>
                        <li><a href="{{ route('page.show', 'refund-policy') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Refund Policy</a></li>
                        <li><a href="{{ route('page.show', 'terms-of-service') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Terms of Service</a></li>
                        <li><a href="{{ route('page.show', 'privacy-policy') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Privacy Policy</a></li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Contact Us</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        @if(!empty($globalSettings['company_email']))
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                <a href="mailto:{{ $globalSettings['company_email'] }}" class="hover:text-white">{{ $globalSettings['company_email'] }}</a>
                            </li>
                        @endif
                        @if(!empty($globalSettings['company_phone']))
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                {{ $globalSettings['company_phone'] }}
                            </li>
                        @endif
                        @if(!empty($globalSettings['company_address']))
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-gray-500 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <span>{!! nl2br(e($globalSettings['company_address'])) !!}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} {{ $globalSettings['company_name'] ?? 'SuronBikes' }}. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('tracking.index') }}" class="hover:text-white transition-colors">Track Your Order</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
