@extends('layouts.storefront')

@section('meta_title', ($currentCategory ? $currentCategory->name . ' - ' : '') . 'Shop - ' . config('app.name'))
@section('meta_description', 'Browse our premium selection of electric bikes, ATVs, and powersports equipment.')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($currentCategory)
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $currentCategory->name }}</h1>
                @if($currentCategory->description)
                    <p class="mt-2 text-base text-gray-500 max-w-3xl">{{ $currentCategory->description }}</p>
                @endif
            </div>
        @elseif(request()->filled('search'))
            <div class="mb-8">
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Search Results for "{{ request('search') }}"</h1>
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <p class="text-gray-500 text-sm">Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results</p>
            
            <form action="{{ route('home') }}" method="GET" class="flex items-center gap-4">
                @if(request()->filled('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request()->filled('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                
                <label for="sort" class="text-sm font-medium text-gray-700 whitespace-nowrap">Sort by</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                </select>
            </form>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-24 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filters.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700">
                        Clear Filters
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-8">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="group block">
                        <div class="relative bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm group-hover:shadow-lg transition-all duration-300 transform group-hover:-translate-y-1">
                            @if($product->featured)
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-600 text-white shadow-sm">
                                        Featured
                                    </span>
                                </div>
                            @endif
                            
                            <div class="aspect-w-4 aspect-h-3 bg-gray-100 flex justify-center items-center overflow-hidden">
                                @if($product->images->count() > 0)
                                    <img src="{{ Storage::url($product->images->first()->path) }}" alt="{{ $product->name }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="text-xs font-semibold text-orange-600 tracking-wide uppercase mb-1">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 truncate">{{ $product->name }}</h3>
                                <p class="text-xl font-extrabold text-gray-900">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
