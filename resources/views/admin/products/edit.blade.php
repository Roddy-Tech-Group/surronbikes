@extends('layouts.admin')

@section('title', 'Edit Product: ' . $product->name)
@section('header', 'Edit Product')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to Products
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" 
          x-data="{ 
            name: '{{ old('name', addslashes($product->name)) }}', 
            slug: '{{ old('slug', $product->slug) }}',
            specs: {{ old('specifications', json_encode($product->specifications ?? [])) }}
          }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column (Main Info) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Basic Info Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Basic Information</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Product Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" x-model="name" required class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                <input type="text" name="slug" id="slug" x-model="slug" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-1 text-xs text-gray-500">Leave blank to regenerate. Auto preview: <span class="font-mono text-gray-700" x-text="name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '')"></span></p>
                                @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                                <select name="category_id" id="category_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price ($) <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required step="0.01" min="0" class="focus:ring-orange-500 focus:border-orange-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                                </div>
                                @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Description <span class="text-red-500">*</span></h3>
                    </div>
                    <div class="p-6">
                        <div class="prose max-w-none">
                            <input id="description" type="hidden" name="description" value="{{ old('description', $product->description) }}">
                            <trix-editor input="description" class="trix-content min-h-[250px] bg-white border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500"></trix-editor>
                        </div>
                        @error('description')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Dynamic Specifications --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h3 class="text-sm font-semibold text-gray-900">Specifications</h3>
                        <button type="button" @click="specs.push({name: '', value: ''})" class="inline-flex items-center text-sm font-medium text-orange-600 hover:text-orange-500">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Add Spec
                        </button>
                    </div>
                    <div class="p-6 space-y-4">
                        <template x-for="(spec, index) in specs" :key="index">
                            <div class="flex gap-4 items-start">
                                <div class="flex-1">
                                    <input type="text" x-model="spec.name" :name="'specifications['+index+'][name]'" placeholder="e.g. Battery" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="flex-1">
                                    <input type="text" x-model="spec.value" :name="'specifications['+index+'][value]'" placeholder="e.g. 60V 32Ah" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="pt-1">
                                    <button type="button" @click="specs.splice(index, 1)" class="mt-1 p-2 text-gray-400 hover:text-red-500 rounded-md hover:bg-red-50">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div x-show="specs.length === 0" class="text-sm text-gray-500 text-center py-4 border-2 border-dashed border-gray-200 rounded-lg">
                            No specifications added. Click "Add Spec" to start.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column (Media & Status) --}}
            <div class="space-y-6">
                
                {{-- Existing Images --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Existing Images</h3>
                    </div>
                    <div class="p-6">
                        @if($product->images->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-sm text-gray-500">No images uploaded yet.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($product->images as $image)
                                    <div class="relative group rounded-lg overflow-hidden border border-gray-200 aspect-square bg-gray-50">
                                        <img src="{{ Storage::url($image->path) }}" alt="" class="object-cover w-full h-full">
                                        
                                        @if($image->is_primary)
                                            <div class="absolute top-2 left-2">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    Primary
                                                </span>
                                            </div>
                                        @endif

                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2">
                                            @if(!$image->is_primary)
                                                <button type="button" onclick="document.getElementById('primary-image-{{ $image->id }}').submit()" class="px-3 py-1 bg-white text-gray-900 rounded-md text-xs font-medium hover:bg-gray-100">
                                                    Set Primary
                                                </button>
                                            @endif
                                            
                                            <button type="button" onclick="if(confirm('Delete this image?')) document.getElementById('delete-image-{{ $image->id }}').submit()" class="px-3 py-1 bg-red-600 text-white rounded-md text-xs font-medium hover:bg-red-700">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Upload New Images --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Upload New Images</h3>
                    </div>
                    <div class="p-6">
                        <label class="block text-sm font-medium text-gray-700">Add Images</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:bg-gray-50 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500">
                                        <span>Upload files</span>
                                        <input id="images" name="images[]" type="file" multiple class="sr-only" accept="image/jpeg,image/png,image/webp">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 5MB</p>
                            </div>
                        </div>
                        @error('images')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Video --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Video</h3>
                    </div>
                    <div class="p-6">
                        <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL</label>
                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $product->video_url) }}" class="mt-1 shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="YouTube or Vimeo URL">
                    </div>
                </div>

                {{-- Status / Featured --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-900">Status</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="featured" name="featured" type="checkbox" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="featured" class="font-medium text-gray-700">Featured Product</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3 border-t border-gray-200 pt-6">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700">
                Save Changes
            </button>
        </div>
    </form>

    {{-- Hidden forms for image actions --}}
    @foreach($product->images as $image)
        <form id="delete-image-{{ $image->id }}" action="{{ route('admin.products.images.destroy', [$product, $image]) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
        @if(!$image->is_primary)
            <form id="primary-image-{{ $image->id }}" action="{{ route('admin.products.images.primary', [$product, $image]) }}" method="POST" class="hidden">
                @csrf
                @method('PATCH')
            </form>
        @endif
    @endforeach
@endsection
