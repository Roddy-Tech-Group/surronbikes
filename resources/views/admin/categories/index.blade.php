@extends('layouts.admin')

@section('title', 'Categories')
@section('header', 'Categories')

@section('content')
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <p class="text-sm text-gray-500 mt-1">Manage product categories</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors shadow-sm">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add Category
            </a>
        </div>
    </div>

    {{-- Search Filter --}}
    <div class="bg-white p-4 rounded-t-xl border border-gray-200 border-b-0">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="max-w-md">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500 placeholder-gray-400">
            </div>
        </form>
    </div>

    <div class="bg-white border border-gray-200 rounded-b-xl shadow-sm overflow-hidden">
        @if($categories->isEmpty())
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No categories found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request()->filled('search'))
                        No categories matched your search criteria. <a href="{{ route('admin.categories.index') }}" class="text-orange-500 hover:text-orange-600">Clear search</a>
                    @else
                        Get started by creating a new category.
                    @endif
                </p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 font-mono">{{ $category->slug }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->products_count > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $category->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" x-data="{ confirmingDelete: false }">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        
                                        <button @click="confirmingDelete = true" type="button" class="text-red-600 hover:text-red-900">Delete</button>

                                        {{-- Delete Confirmation Modal --}}
                                        <div x-show="confirmingDelete" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                <div x-show="confirmingDelete" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                                <div x-show="confirmingDelete" @click.away="confirmingDelete = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Delete Category</h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-500">
                                                                    Are you sure you want to delete the category "{{ $category->name }}"?
                                                                    @if($category->products_count > 0)
                                                                        <br><br><span class="font-semibold text-red-600">Warning: This category contains {{ $category->products_count }} products. You cannot delete it until the products are reassigned or deleted.</span>
                                                                    @else
                                                                        This action cannot be undone.
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" @if($category->products_count > 0) disabled @endif class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                                                Delete Category
                                                            </button>
                                                        </form>
                                                        <button @click="confirmingDelete = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($categories->hasPages())
                <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                    {{ $categories->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
