@extends('layouts.storefront')

@section('meta_title', $product->name . ' - ' . config('app.name'))
@section('meta_description', Str::limit(strip_tags($product->description), 150))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center text-sm text-gray-500 mb-8 gap-2">
            <a href="{{ route('home') }}" class="hover:text-orange-600 transition-colors">Shop</a>
            <span>/</span>
            @if($product->category)
                <a href="{{ route('home', ['category' => $product->category->slug]) }}" class="hover:text-orange-600 transition-colors">{{ $product->category->name }}</a>
                <span>/</span>
            @endif
            <span class="text-gray-900 font-medium">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            
            {{-- Image Gallery Carousel --}}
            <div x-data="{ 
                images: [
                    @foreach($product->images as $image)
                        '{{ Storage::url($image->path) }}',
                    @endforeach
                ],
                currentIndex: 0,
                get mainImage() { return this.images[this.currentIndex]; },
                hasImages: {{ $product->images->count() > 0 ? 'true' : 'false' }},
                next() { 
                    this.currentIndex = this.currentIndex === this.images.length - 1 ? 0 : this.currentIndex + 1; 
                },
                prev() { 
                    this.currentIndex = this.currentIndex === 0 ? this.images.length - 1 : this.currentIndex - 1; 
                }
            }">
                <div class="relative aspect-w-4 aspect-h-3 bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm mb-4 group">
                    <template x-if="hasImages">
                        <img :src="mainImage" x-transition class="w-full h-full object-contain p-4" alt="{{ $product->name }}">
                    </template>
                    <template x-if="!hasImages">
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <svg class="h-24 w-24 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </template>

                    <!-- Navigation Arrows -->
                    <template x-if="images.length > 1">
                        <div class="absolute inset-0 flex items-center justify-between p-4">
                            <button @click="prev()" type="button" class="bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-md focus:outline-none focus:ring-2 focus:ring-orange-500 backdrop-blur-sm transition-all">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                            </button>
                            <button @click="next()" type="button" class="bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-md focus:outline-none focus:ring-2 focus:ring-orange-500 backdrop-blur-sm transition-all">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <!-- Thumbnails -->
                <template x-if="images.length > 1">
                    <div class="grid grid-cols-5 gap-3">
                        <template x-for="(img, index) in images" :key="index">
                            <button @click="currentIndex = index" 
                                    class="aspect-w-1 aspect-h-1 bg-white rounded-lg border-2 overflow-hidden transition-all focus:outline-none"
                                    :class="currentIndex === index ? 'border-orange-500 ring-2 ring-orange-500/50' : 'border-gray-200 hover:border-orange-300 opacity-70 hover:opacity-100'">
                                <img :src="img" class="w-full h-full object-cover" alt="Thumbnail">
                            </button>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Product Info --}}
            <div class="flex flex-col">
                <div class="mb-6">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">{{ $product->name }}</h1>
                    <p class="mt-4 text-3xl font-bold text-orange-600">${{ number_format($product->price, 2) }}</p>
                </div>

                @if($product->description)
                    <div class="prose prose-orange text-gray-600 mb-8">
                        {!! $product->description !!}
                    </div>
                @endif

                <div class="mt-auto pt-8 border-t border-gray-200">
                    <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="w-full sm:w-32">
                            <label for="quantity" class="sr-only">Quantity</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="10" class="block w-full text-center rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 text-lg py-3">
                        </div>
                        
                        <button type="submit" class="flex-1 bg-orange-600 border border-transparent rounded-lg shadow-sm py-3 px-8 flex items-center justify-center text-base font-bold text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors uppercase tracking-wider">
                            Add to Cart
                        </button>
                    </form>
                </div>

                {{-- Specs --}}
                @if($product->specifications && count($product->specifications) > 0)
                    <div class="mt-12">
                        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2 mb-4">Specifications</h3>
                        <dl class="divide-y divide-gray-100">
                            @foreach($product->specifications as $key => $spec)
                                @if(is_array($spec) && isset($spec['name']) && isset($spec['value']))
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">{{ $spec['name'] }}</dt>
                                        <dd class="text-sm font-semibold text-gray-900">{{ $spec['value'] }}</dd>
                                    </div>
                                @elseif(is_string($spec) && !is_numeric($key))
                                    {{-- Fallback for simple key-value array format if any old data exists --}}
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">{{ Str::title(str_replace('_', ' ', $key)) }}</dt>
                                        <dd class="text-sm font-semibold text-gray-900">{{ $spec }}</dd>
                                    </div>
                                @endif
                            @endforeach
                        </dl>
                    </div>
                @endif
                
                {{-- Video Embed --}}
                @if($product->video_url)
                    <div class="mt-12">
                        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2 mb-4">Product Video</h3>
                        <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden shadow-sm bg-gray-100">
                            <iframe src="{{ $product->video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->isNotEmpty())
            <div class="mt-24 border-t border-gray-200 pt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related->slug) }}" class="group block">
                            <div class="relative bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm group-hover:shadow-lg transition-all duration-300 transform group-hover:-translate-y-1">
                                <div class="aspect-w-4 aspect-h-3 bg-gray-100 flex justify-center items-center overflow-hidden">
                                    @if($related->images->count() > 0)
                                        @php $imagePath = $related->primaryImage ? $related->primaryImage->path : $related->images->first()->path; @endphp
                                        <img src="{{ Storage::url($imagePath) }}" alt="{{ $related->name }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-gray-900 mb-1 truncate">{{ $related->name }}</h3>
                                    <p class="text-lg font-extrabold text-orange-600">${{ number_format($related->price, 2) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
