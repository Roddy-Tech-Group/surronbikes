@extends('layouts.storefront')

@section('meta_title', $page->meta_title ?? $page->title . ' - ' . config('app.name'))
@section('meta_description', $page->meta_description ?? '')

@section('content')
    @if($page->slug === 'about-us')
        @php
            $aboutImage = \App\Models\Setting::get('about_us_image_path');
        @endphp
        
        {{-- SECTION 1: HERO --}}
        <div class="relative bg-gray-900 min-h-[60vh] flex items-center justify-center overflow-hidden">
            @if($aboutImage)
                <img src="{{ Storage::url($aboutImage) }}" alt="{{ $page->title }}" class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-gray-900/90"></div>
            @endif
            
            <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto mt-12">
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-white mb-6 uppercase" style="letter-spacing: 0.05em;">
                    {{ $page->title }}
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 max-w-2xl mx-auto font-light mb-8">
                    Discover the passion, innovation, and drive behind our electric revolution.
                </p>
                <div class="w-24 h-1.5 bg-orange-500 mx-auto rounded-full"></div>
            </div>
        </div>

        {{-- SECTION 2: COMPANY STORY --}}
        @php
            $storyImage = \App\Models\Setting::get('about_us_story_image_path');
        @endphp
        <div class="bg-gray-50 py-20 md:py-28 border-b border-gray-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col-reverse lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                    <div class="prose prose-lg md:prose-xl prose-orange text-gray-700 font-medium leading-relaxed mt-12 lg:mt-0">
                        {!! $page->content !!}
                    </div>
                    @if($storyImage)
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl w-full">
                        <img src="{{ Storage::url($storyImage) }}" alt="SuronBikes Company Story" class="w-full h-auto object-cover aspect-[4/3] lg:aspect-auto">
                        <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-3xl"></div>
                    </div>
                    @else
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gray-200 aspect-[4/3] flex items-center justify-center w-full">
                        <span class="text-gray-400 font-medium">Story Image (Upload in Settings)</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- SECTION 3: WHY CHOOSE US --}}
        <div class="bg-white py-20 md:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">Why Choose Us</h2>
                    <div class="mt-4 w-16 h-1 bg-orange-500 mx-auto rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    {{-- Card 1 --}}
                    <div class="group bg-gray-50 rounded-2xl p-8 hover:bg-gray-900 transition-colors duration-300 text-center border border-gray-100 hover:border-gray-900 shadow-sm flex flex-col items-center">
                        <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-white transition-colors duration-300">Premium Products</h3>
                        <p class="text-gray-500 group-hover:text-gray-400 transition-colors duration-300">We carefully curate only the highest performing electric bikes on the market.</p>
                    </div>

                    {{-- Card 2 --}}
                    <div class="group bg-gray-50 rounded-2xl p-8 hover:bg-gray-900 transition-colors duration-300 text-center border border-gray-100 hover:border-gray-900 shadow-sm flex flex-col items-center">
                        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-white transition-colors duration-300">Reliable Support</h3>
                        <p class="text-gray-500 group-hover:text-gray-400 transition-colors duration-300">Our team of experts is always ready to assist you before and after your purchase.</p>
                    </div>

                    {{-- Card 3 --}}
                    <div class="group bg-gray-50 rounded-2xl p-8 hover:bg-gray-900 transition-colors duration-300 text-center border border-gray-100 hover:border-gray-900 shadow-sm flex flex-col items-center">
                        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-white transition-colors duration-300">Secure Ordering</h3>
                        <p class="text-gray-500 group-hover:text-gray-400 transition-colors duration-300">Your transactions are protected by industry-leading encryption protocols.</p>
                    </div>

                    {{-- Card 4 --}}
                    <div class="group bg-gray-50 rounded-2xl p-8 hover:bg-gray-900 transition-colors duration-300 text-center border border-gray-100 hover:border-gray-900 shadow-sm flex flex-col items-center">
                        <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-500 group-hover:text-white transition-colors duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-white transition-colors duration-300">Fast Shipping</h3>
                        <p class="text-gray-500 group-hover:text-gray-400 transition-colors duration-300">Get your new ride delivered quickly and securely to your doorstep.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 4: TESTIMONIALS --}}
        @if(isset($testimonials) && $testimonials->isNotEmpty())
        <div class="bg-gray-50 py-20 md:py-28 overflow-hidden" x-data="{ showReviewModal: false }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">What Our Riders Say</h2>
                        <div class="mt-4 w-16 h-1 bg-orange-500 rounded-full"></div>
                    </div>
                    <button @click="showReviewModal = true" class="hidden md:inline-flex items-center text-orange-600 font-semibold hover:text-orange-700 mt-4 md:mt-0 px-6 py-3 border border-orange-200 rounded-xl hover:bg-orange-50 transition-colors">
                        Submit a Review
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>

                <div class="flex overflow-x-auto pb-8 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 snap-x snap-mandatory hide-scrollbar space-x-6">
                    @foreach($testimonials as $testimonial)
                        <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 flex flex-col relative flex-none w-[85vw] sm:w-[400px] snap-center">
                            <div class="absolute -top-4 right-8 text-orange-100">
                                <svg class="h-16 w-16" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"></path>
                                </svg>
                            </div>
                            <div class="flex items-center text-orange-500 mb-6 relative z-10">
                                @for($i = 0; $i < $testimonial->rating; $i++)
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <blockquote class="flex-grow relative z-10">
                                <p class="text-gray-700 italic leading-relaxed">"{{ $testimonial->content }}"</p>
                            </blockquote>
                            <div class="mt-8 flex items-center relative z-10">
                                @if($testimonial->image_path)
                                    <img class="h-12 w-12 rounded-full object-cover mr-4 shadow-sm" src="{{ Storage::url($testimonial->image_path) }}" alt="{{ $testimonial->customer_name }}">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center mr-4 text-orange-600 font-bold text-lg shadow-sm">
                                        {{ substr($testimonial->customer_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-gray-900">{{ $testimonial->customer_name }}</div>
                                    @if($testimonial->role)
                                        <div class="text-sm text-gray-500">{{ $testimonial->role }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8 text-center md:hidden">
                    <button @click="showReviewModal = true" class="inline-flex items-center text-orange-600 font-semibold hover:text-orange-700 px-6 py-3 border border-orange-200 rounded-xl hover:bg-orange-50 transition-colors w-full justify-center">
                        Submit a Review
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>

            {{-- Review Modal --}}
            <div x-show="showReviewModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                <div x-show="showReviewModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div x-show="showReviewModal" x-transition.opacity.duration.300ms class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start w-full">
                                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                            <h3 class="text-2xl font-bold leading-6 text-gray-900 mb-6" id="modal-title">Submit a Review</h3>
                                            <div class="space-y-5 text-left">
                                                <div>
                                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                                    <input type="text" name="customer_name" id="customer_name" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                                                </div>
                                                <div>
                                                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role / Vehicle (Optional)</label>
                                                    <input type="text" name="role" id="role" placeholder="e.g. Daily Commuter" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                                                </div>
                                                <div>
                                                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                                                    <select id="rating" name="rating" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                                                        <option value="5">5 Stars</option>
                                                        <option value="4">4 Stars</option>
                                                        <option value="3">3 Stars</option>
                                                        <option value="2">2 Stars</option>
                                                        <option value="1">1 Star</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
                                                    <textarea id="content" name="content" rows="4" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"></textarea>
                                                </div>
                                                <div>
                                                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Photo (Optional)</label>
                                                    <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3 border-t border-gray-100">
                                    <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-orange-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 sm:w-auto">Submit Review</button>
                                    <button type="button" @click="showReviewModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
        @endif

        {{-- SECTION 5: COMPANY STATS --}}
        @if(isset($stats))
        <div class="bg-gray-900 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center divide-x divide-gray-800">
                    <div>
                        <div class="text-4xl md:text-5xl font-extrabold text-white mb-2">{{ $stats['products'] }}</div>
                        <div class="text-gray-400 font-medium uppercase tracking-wide text-xs sm:text-sm">Premium Products</div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-5xl font-extrabold text-orange-500 mb-2">{{ $stats['orders'] }}</div>
                        <div class="text-gray-400 font-medium uppercase tracking-wide text-xs sm:text-sm">Riders Served</div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-5xl font-extrabold text-white mb-2">{{ $stats['categories'] }}</div>
                        <div class="text-gray-400 font-medium uppercase tracking-wide text-xs sm:text-sm">Vehicle Categories</div>
                    </div>
                    <div>
                        <div class="text-4xl md:text-5xl font-extrabold text-orange-500 mb-2">{{ $stats['years'] }}</div>
                        <div class="text-gray-400 font-medium uppercase tracking-wide text-xs sm:text-sm">Years Serving</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- SECTION 6: CALL TO ACTION --}}
        <div class="bg-orange-600 py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-6">Ready to Find Your Next Ride?</h2>
                <p class="text-xl text-orange-100 mb-10">Join the electric revolution today and experience uncompromising performance.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl text-orange-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-orange-600 focus:ring-white shadow-xl transition-transform hover:-translate-y-1">
                        Browse Inventory
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex justify-center items-center px-8 py-4 border-2 border-white text-lg font-bold rounded-xl text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-orange-600 focus:ring-white transition-colors">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gray-900 py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl">{{ $page->title }}</h1>
            </div>
        </div>

        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="prose prose-lg prose-orange max-w-none text-gray-600">
                {!! $page->content !!}
            </div>
        </div>
    @endif
@endsection
