<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex" x-data="{ sidebarOpen: false }">

    {{-- Mobile Overlay --}}
    <div
        x-show="sidebarOpen"
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
        class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:z-auto"
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
                    ['route' => 'admin.dashboard', 'label' => 'Orders', 'icon' => 'receipt', 'match' => 'admin.orders*'],
                    ['route' => 'admin.payment-methods.index', 'label' => 'Payment Methods', 'icon' => 'credit-card', 'match' => 'admin.payment-methods*'],
                    ['route' => 'admin.dashboard', 'label' => 'Contact Messages', 'icon' => 'envelope', 'match' => 'admin.contact-messages*'],
                    ['route' => 'admin.dashboard', 'label' => 'FAQs', 'icon' => 'question', 'match' => 'admin.faqs*'],
                    ['route' => 'admin.dashboard', 'label' => 'Pages', 'icon' => 'document', 'match' => 'admin.pages*'],
                    ['route' => 'admin.dashboard', 'label' => 'Settings', 'icon' => 'cog', 'match' => 'admin.settings*'],
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
        </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col min-h-screen lg:min-w-0">
        {{-- Top Bar --}}
        <header class="bg-white border-b border-gray-200 px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between sticky top-0 z-30">
            {{-- Mobile menu button --}}
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors"
            >
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <div class="flex-1 flex items-center justify-between px-4 sm:px-6">
                <div class="flex-1 flex items-center">
                    {{-- Global Search --}}
                    <div class="w-full max-w-lg lg:max-w-xs relative hidden sm:block">
                        <label for="global_search" class="sr-only">Search</label>
                        <div class="relative text-gray-400 focus-within:text-gray-600">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="global_search" name="search" class="block w-full rounded-md border-0 bg-gray-100 py-1.5 pl-10 pr-3 text-gray-900 focus:ring-2 focus:ring-orange-500 sm:text-sm sm:leading-6" placeholder="Search orders, products, etc..." type="search">
                        </div>
                    </div>
                </div>

            {{-- Admin user --}}
            <div class="flex items-center gap-4" x-data="{ dropdownOpen: false }">
                <div class="relative">
                    <button
                        @click="dropdownOpen = !dropdownOpen"
                        @click.away="dropdownOpen = false"
                        class="flex items-center gap-2 text-sm text-gray-700 hover:text-gray-900 transition-colors"
                    >
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-xs font-semibold text-gray-600">
                                {{ substr(Auth::guard('admin')->user()->name, 0, 2) }}
                            </span>
                        </div>
                        <span class="hidden sm:inline font-medium">{{ Auth::guard('admin')->user()->name }}</span>
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div
                        x-show="dropdownOpen"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                    >
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                Sign Out
                            </button>
                        </form>
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
    </div>
</body>
</html>
