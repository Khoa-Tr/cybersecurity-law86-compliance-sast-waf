@extends('layouts.app')
@section('title', 'Corporate Announcements')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Official Corporate Announcement (Static) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shadow-md">
                        BOD
                    </div>
                    <div>
                        <p class="text-base font-bold text-gray-900">Board of Directors</p>
                        <p class="text-xs text-gray-500 flex items-center gap-1">
                            <span>Posted recently</span>
                            <span>•</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700">Company-wide</span>
                        </p>
                    </div>
                </div>
            </div>
            
            <h2 class="text-xl font-bold text-gray-900 mb-4">Q3 Corporate Direction & New HR Policies</h2>
            <div class="text-sm text-gray-700 space-y-3 leading-relaxed">
                <p>Dear NexusHR Employees,</p>
                <p>We are excited to announce our Q3 strategic direction. Following our recent all-hands meeting, the HR department has updated several key policies regarding remote work and project allowances. Please review the new guidelines in the employee handbook.</p>
                <p>We welcome your feedback and thoughts. Please use the comment section below to share your perspectives.</p>
                <p class="font-medium text-gray-900 mt-4">- Executive Team</p>
            </div>
        </div>
        
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex items-center justify-between">
            <div class="flex items-center space-x-6 text-sm text-gray-500">
                <button class="flex items-center space-x-2 hover:text-indigo-600 transition font-medium">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.514"></path></svg>
                    <span>124 Likes</span>
                </button>
                <button class="flex items-center space-x-2 text-indigo-600 font-medium">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <span>{{ $posts->count() }} Comments</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Feedback/Comment Input Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4">Employee Feedback</h3>
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200">
                    {{ strtoupper(substr(session('username'), 0, 1)) }}
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <form action="/posts" method="POST">
                    <input type="hidden" name="title" value="Employee Feedback">
                    <div class="border border-gray-300 rounded-xl overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 shadow-sm transition">
                        <textarea rows="3" name="content" class="block w-full py-3 px-4 border-0 resize-none focus:ring-0 sm:text-sm text-gray-900 placeholder-gray-500 bg-white" placeholder="Share your thoughts with the team..."></textarea>
                    </div>
                    <div class="mt-3 flex items-center justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            Post Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Feed / Comments List -->
    <div class="space-y-4">
        @forelse($posts as $post)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex space-x-3">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold">
                        {{ strtoupper(substr($post->user->username ?? 'U', 0, 1)) }}
                    </div>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-gray-900">
                            {{ ucfirst($post->user->username ?? 'Unknown') }}
                            <span class="ml-2 font-normal text-xs text-gray-500" data-timestamp="{{ $post->created_at->timestamp }}">{{ $post->created_at->diffForHumans() }}</span>
                        </p>
                        @if($post->user_id == session('user_id') || session('role') === 'admin')
                        <form method="POST" action="/posts/{{ $post->id }}" onsubmit="return confirm('Delete this feedback?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                    <div class="mt-1 text-sm text-gray-800 break-words leading-relaxed">
                        {!! $post->content !!}
                    </div>
                    <div class="mt-2 flex items-center gap-4 text-xs text-gray-500 font-medium">
                        <button class="hover:text-indigo-600 transition">Like</button>
                        <button class="hover:text-indigo-600 transition">Reply</button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-sm text-gray-500">
            No feedback has been posted yet. Be the first to share your thoughts.
        </div>
        @endforelse
    </div>

</div>
@endsection
