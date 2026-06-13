@extends('layouts.storefront')

@section('meta_title', $page->meta_title ?? $page->title . ' - ' . config('app.name'))
@section('meta_description', $page->meta_description ?? '')

@section('content')
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
@endsection
