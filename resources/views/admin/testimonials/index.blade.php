@extends('layouts.admin')

@section('title', 'Manage Testimonials')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Testimonials</h1>
        <p class="mt-2 text-sm text-gray-700">Manage customer testimonials displayed on the storefront.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-orange-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 sm:w-auto">
            Add Testimonial
        </a>
    </div>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul role="list" class="divide-y divide-gray-200">
        @forelse($testimonials as $testimonial)
            <li>
                <div class="px-4 py-4 sm:px-6 flex items-center justify-between">
                    <div class="flex items-center">
                        @if($testimonial->image_path)
                            <img src="{{ Storage::url($testimonial->image_path) }}" alt="" class="h-12 w-12 rounded-full object-cover mr-4">
                        @else
                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-orange-600 truncate">{{ $testimonial->customer_name }}</p>
                            <p class="mt-1 flex items-center text-sm text-gray-500">
                                <span class="truncate">{{ $testimonial->role }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="ml-2 flex-shrink-0 flex items-center space-x-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $testimonial->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        
                        <div class="flex items-center text-yellow-400">
                            @for($i = 0; $i < $testimonial->rating; $i++)
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li>
                <div class="px-4 py-8 text-center text-sm text-gray-500">
                    No testimonials found.
                </div>
            </li>
        @endforelse
    </ul>
</div>
@endsection
