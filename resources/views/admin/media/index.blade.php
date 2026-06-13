@extends('layouts.admin')

@section('title', 'Media Manager')
@section('header', 'Media Manager')

@section('content')
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <p class="text-sm text-gray-500 mt-1">Upload and manage images for content, FAQs, and pages.</p>
        </div>
        <div class="mt-4 sm:mt-0" x-data="{ open: false }">
            <button @click="open = true" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>
                Upload Files
            </button>

            {{-- Upload Modal --}}
            <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    
                    <div x-show="open" x-transition @click.away="open = false" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Upload Media</h3>
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Select Images (Max 5MB each)</label>
                                    <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-gray-50">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500">
                                                    <span>Upload files</span>
                                                    <input id="file-upload" name="files[]" type="file" class="sr-only" multiple accept="image/png, image/jpeg, image/webp, image/svg+xml" required>
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, SVG, WEBP up to 5MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Upload
                                </button>
                                <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($mediaFiles->isEmpty())
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm px-6 py-16 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900">No media found</h3>
            <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto font-medium">Upload images to reference them inside product details, categories or pages.</p>
        </div>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6" x-data="mediaManager()">
            @foreach($mediaFiles as $media)
                <div class="relative group bg-white border border-gray-200 rounded-lg overflow-hidden flex flex-col shadow-sm hover:shadow-md transition-shadow">
                    <div class="aspect-w-1 aspect-h-1 bg-gray-100 flex items-center justify-center p-2 relative h-32">
                        <img src="{{ $media->url }}" alt="{{ $media->file_name }}" class="object-contain max-h-full max-w-full">
                        
                        {{-- Hover Overlay Actions --}}
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <button type="button" @click="copyToClipboard('{{ $media->url }}')" class="p-2 bg-white text-gray-900 rounded-full hover:bg-gray-100 focus:outline-none" title="Copy URL">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </button>
                            <form method="POST" action="{{ route('admin.media.destroy', $media) }}" @submit.prevent="if(confirm('Are you sure you want to delete this file? Any content using this URL will break.')) $el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700 focus:outline-none" title="Delete">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-2 border-t border-gray-100">
                        <p class="text-xs font-medium text-gray-900 truncate" title="{{ $media->file_name }}">
                            {{ $media->file_name }}
                        </p>
                        <p class="text-[10px] text-gray-500 mt-0.5 flex justify-between">
                            <span>{{ $media->formatted_size }}</span>
                            <span>{{ $media->created_at->format('M d') }}</span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($mediaFiles->hasPages())
            <div class="mt-6">
                {{ $mediaFiles->links() }}
            </div>
        @endif
        
        {{-- Toast Notification --}}
        <div x-show="toast.show" x-transition.opacity class="fixed bottom-4 right-4 bg-gray-900 text-white px-4 py-2 rounded-lg shadow-lg text-sm" style="display: none;" x-text="toast.message"></div>
    @endif
    
    @push('scripts')
        <script>
            function mediaManager() {
                return {
                    toast: {
                        show: false,
                        message: ''
                    },
                    copyToClipboard(url) {
                        // Create a temporary input to copy from
                        const el = document.createElement('textarea');
                        el.value = url;
                        document.body.appendChild(el);
                        el.select();
                        document.execCommand('copy');
                        document.body.removeChild(el);
                        
                        this.toast.message = 'URL copied to clipboard!';
                        this.toast.show = true;
                        setTimeout(() => { this.toast.show = false; }, 3000);
                    }
                }
            }
        </script>
    @endpush
@endsection
