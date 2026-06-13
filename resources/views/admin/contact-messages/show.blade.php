@extends('layouts.admin')

@section('title', 'Message from ' . $contactMessage->name)
@section('header', 'Message Details')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.contact-messages.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Back to Messages
        </a>
        
        <div class="flex gap-3">
            <form method="POST" action="{{ route('admin.contact-messages.toggle', $contactMessage) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Mark as {{ $contactMessage->is_read ? 'Unread' : 'Read' }}
                </button>
            </form>
            <form method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" x-data @submit.prevent="if(confirm('Are you sure you want to delete this message?')) $el.submit()">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete Message
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="sm:flex sm:items-center sm:justify-between border-b border-gray-200 pb-6 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $contactMessage->subject }}</h2>
                    <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                        <span class="font-medium text-gray-900">{{ $contactMessage->name }}</span>
                        <span>&middot;</span>
                        <a href="mailto:{{ $contactMessage->email }}" class="text-indigo-600 hover:underline">{{ $contactMessage->email }}</a>
                    </div>
                </div>
                <div class="mt-4 sm:mt-0 text-right text-sm text-gray-500">
                    {{ $contactMessage->created_at->format('l, F j, Y \a\t h:i A') }}
                    <div class="mt-1">
                        ({{ $contactMessage->created_at->diffForHumans() }})
                    </div>
                </div>
            </div>
            
            <div class="prose max-w-none text-gray-700">
                {!! nl2br(e($contactMessage->message)) !!}
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ urlencode($contactMessage->subject) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                </svg>
                Reply via Email
            </a>
        </div>
    </div>
@endsection
