@extends('layouts.app')
@section('title', 'View Detail - ' . Str::limit($post->title, 20))

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="/dashboard" class="hover:text-indigo-600 transition">Dashboard</a></li>
            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li><a href="/posts" class="hover:text-indigo-600 transition">Announcements</a></li>
            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li class="font-medium text-gray-800" aria-current="page">View Detail</li>
        </ol>
    </nav>

    <!-- Post Detail Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center space-x-4">
                    <div class="h-14 w-14 rounded-full bg-gradient-to-tr from-indigo-100 to-blue-50 flex items-center justify-center text-indigo-700 font-bold text-xl border border-indigo-100">
                        {{ strtoupper(substr($post->user->username ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-900">{{ ucfirst($post->user->username ?? 'Unknown') }}</p>
                        <p class="text-sm text-gray-500 flex items-center gap-2">
                            <span>Corporate Employee</span>
                            <span>•</span>
                            <span data-timestamp="{{ $post->created_at->timestamp }}">{{ $post->created_at->format('M d, Y') }}</span>
                        </p>
                    </div>
                </div>

                @if($post->user_id == session('user_id') || session('role') === 'admin')
                <div class="flex items-center space-x-2">
                    <form method="POST" action="/posts/{{ $post->id }}" onsubmit="return confirm('Delete this record?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-200 text-xs font-medium rounded text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none transition">
                            <svg class="-ml-0.5 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Delete
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <!-- VULNERABLE RENDER - NO ESCAPING -->
            <div class="prose max-w-none text-gray-800 leading-relaxed">
                <h1 class="text-2xl font-bold text-gray-900 mb-4">{!! $post->title !!}</h1>
                <div class="text-base">
                    {!! $post->content !!}
                </div>
            </div>
            
        </div>
        
        <!-- Interactive Actions -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex items-center justify-between">
            <div class="flex space-x-6">
                <button class="flex items-center space-x-2 text-gray-500 hover:text-indigo-600 transition font-medium">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.514"></path></svg>
                    <span>Like</span>
                </button>
                <button class="flex items-center space-x-2 text-gray-500 hover:text-indigo-600 transition font-medium">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <span>Comment</span>
                </button>
                <button class="flex items-center space-x-2 text-gray-500 hover:text-indigo-600 transition font-medium">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    <span>Share</span>
                </button>
            </div>
            
            <div class="text-xs text-gray-400">
                Post ID: {{ $post->id }}
            </div>
        </div>
    </div>
</div>
@endsection
