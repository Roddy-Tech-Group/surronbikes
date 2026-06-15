<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex" x-data="{ sidebarOpen: false }">

    {{-- Mobile Overlay --}}
    <div
        x-show="sidebarOpen"
        style="display: none;"
        x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        @click="sidebarOpen = false"
    ></div>

    {{-- Sidebar --}}
    <aside
        class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transform transition-transform duration-200 ease-in-out -translate-x-full lg:translate-x-0 lg:static lg:z-auto"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        {{-- Brand --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-800">
            <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center font-bold text-sm">SB</div>
            <span class="text-lg font-semibold tracking-tight">SuronBikes</span>
        </div>

        {{-- Navigation --}}
        <nav class="mt-4 px-3 space-y-1">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
                    ['route' => 'admin.categories.index', 'label' => 'Categories', 'icon' => 'folder', 'match' => 'admin.categories*'],
                    ['route' => 'admin.products.index', 'label' => 'Products', 'icon' => 'cube', 'match' => 'admin.products*'],
                    ['route' => 'admin.orders.index', 'label' => 'Orders', 'icon' => 'receipt', 'match' => 'admin.orders*'],
                    ['route' => 'admin.payment-methods.index', 'label' => 'Payment Methods', 'icon' => 'credit-card', 'match' => 'admin.payment-methods*'],
                    ['route' => 'admin.contact-messages.index', 'label' => 'Contact Messages', 'icon' => 'envelope', 'match' => 'admin.contact-messages*'],
                    ['route' => 'admin.faqs.index', 'label' => 'FAQs', 'icon' => 'question', 'match' => 'admin.faqs*'],
                    ['route' => 'admin.testimonials.index', 'label' => 'Testimonials', 'icon' => 'star', 'match' => 'admin.testimonials*'],

                    ['route' => 'admin.admins.index', 'label' => 'Administrators', 'icon' => 'user-group', 'match' => 'admin.admins*'],
                    ['route' => 'admin.settings.index', 'label' => 'Settings', 'icon' => 'cog', 'match' => 'admin.settings*'],
                ];
            @endphp

            @foreach($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['match'] ?? $item['route']);
                @endphp
                <a
                    href="{{ route($item['route']) }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150
                        {{ $isActive ? 'bg-orange-500/10 text-orange-400' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-200' }}"
                >
                    @include('admin.partials.icons.' . $item['icon'])
                    {{ $item['label'] }}
                </a>
            @endforeach

            {{-- Pages Dropdown --}}
            <div x-data="{ open: {{ request()->routeIs('admin.pages*') ? 'true' : 'false' }} }" class="space-y-1">
                <button
                    @click="open = !open"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-colors duration-150 text-gray-400 hover:bg-gray-800 hover:text-gray-200"
                    :class="{ 'bg-gray-800 text-gray-200': open }"
                >
                    <div class="flex items-center gap-3">
                        @include('admin.partials.icons.document')
                        Pages
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <div x-show="open" x-collapse class="pl-10 pr-3 space-y-1 py-1" style="display: none;">
                    @if(isset($adminPages) && $adminPages->isNotEmpty())
                        @foreach($adminPages as $page)
                            @php
                                $isPageActive = request()->is('admin/pages/' . $page->id . '*');
                            @endphp
                            <a href="{{ route('admin.pages.edit', $page) }}" 
                               class="block px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150 {{ $isPageActive ? 'bg-orange-500/10 text-orange-400' : 'text-gray-400 hover:text-gray-200' }}">
                                {{ $page->title }}
                            </a>
                        @endforeach
                    @else
                        <span class="block px-3 py-2 text-sm text-gray-500">No pages found</span>
                    @endif
                </div>
            </div>
        </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col min-h-screen min-w-0">
        {{-- Top Bar --}}
        <header class="bg-white border-b border-gray-200 px-4 sm:px-6 lg:px-8 h-16 flex items-center gap-4 sticky top-0 z-30">
            {{-- Mobile menu button --}}
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors shrink-0"
            >
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            {{-- Global Search --}}
            <div class="flex-1 flex items-center lg:justify-center">
                <div class="w-full max-w-lg lg:max-w-md relative">
                    <form method="GET" action="{{ url()->current() }}">
                        @php
                            $searchPlaceholder = 'Search...';
                            if (request()->routeIs('admin.products*')) {
                                $searchPlaceholder = 'Search products...';
                            } elseif (request()->routeIs('admin.categories*')) {
                                $searchPlaceholder = 'Search categories...';
                            } elseif (request()->routeIs('admin.orders*')) {
                                $searchPlaceholder = 'Search orders...';
                            } elseif (request()->routeIs('admin.faqs*')) {
                                $searchPlaceholder = 'Search FAQs...';
                            } elseif (request()->routeIs('admin.contact-messages*')) {
                                $searchPlaceholder = 'Search messages...';
                            } elseif (request()->routeIs('admin.admins*')) {
                                $searchPlaceholder = 'Search admins...';
                            }
                        @endphp
                        {{-- Keep other query parameters when searching, except 'search' and 'page' --}}
                        @foreach(request()->except(['search', 'page']) as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <label for="global_search" class="sr-only">{{ $searchPlaceholder }}</label>
                        <div class="relative text-gray-400 focus-within:text-gray-600">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="global_search" name="search" value="{{ request('search') }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 py-2 pl-10 pr-3 text-gray-900 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm h-[40px] min-h-[40px]" placeholder="{{ $searchPlaceholder }}" type="search">
                        </div>
                    </form>
                </div>
            </div>

            {{-- Admin user --}}
            <div class="flex items-center shrink-0 lg:absolute lg:right-8" x-data="{ dropdownOpen: false }">
                <div class="relative" @mouseenter="dropdownOpen = true" @mouseleave="dropdownOpen = false">
                    <button
                        @click="dropdownOpen = !dropdownOpen"
                        class="flex items-center gap-2 text-sm text-gray-700 hover:text-gray-900 transition-colors focus:outline-none"
                    >
                        <div class="w-9 h-9 bg-gray-50 border border-gray-200 hover:border-gray-300 transition-colors rounded-full flex items-center justify-center text-gray-500 overflow-hidden shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="hidden sm:inline font-medium">{{ Auth::guard('admin')->user()->name }}</span>
                    </button>

                    {{-- Dropdown --}}
                    <div
                        x-show="dropdownOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50 overflow-hidden"
                        style="display: none;"
                    >
                        <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/50">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::guard('admin')->user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate mt-0.5">{{ Auth::guard('admin')->user()->email }}</p>
                        </div>
                        <div class="py-1">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm" x-data="{ show: true }" x-show="show">
                    <div class="flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm" x-data="{ show: true }" x-show="show">
                    <div class="flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                        <button @click="show = false" class="text-red-500 hover:text-red-700">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        {{-- Admin Footer --}}
        <footer class="mt-auto border-t border-gray-200 bg-white px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                <div>
                    &copy; {{ date('Y') }} SuronBikes. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
    @stack('scripts')
</body>
</html>
