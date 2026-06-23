@extends('layouts.app')
@section('title', 'Publish Corporate Update')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="/dashboard" class="hover:text-indigo-600 transition">Dashboard</a></li>
            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li><a href="/posts" class="hover:text-indigo-600 transition">Announcements</a></li>
            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li class="font-medium text-gray-800" aria-current="page">Publish Update</li>
        </ol>
    </nav>

    <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-white">
            <h3 class="text-lg leading-6 font-semibold text-gray-900">Publish Internal Update</h3>
            <p class="mt-1 text-sm text-gray-500">Share corporate news, policy changes, or department updates with the entire company.</p>
        </div>
        <div class="p-6">
            <form method="POST" action="/posts" class="space-y-6">
                <!-- XSS & CSRF Vulnerability exists here because no @csrf and raw output elsewhere -->
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Update Subject</label>
                    <input type="text" name="title" required 
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="e.g. Q4 Marketing Strategy Details">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Details & Context</label>
                    <textarea name="content" rows="8" required
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Provide full details of the update. Formatting is supported."></textarea>
                </div>
                
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-xs text-blue-800">
                        Updates published here are visible to all employees via the Internal Announcements feed. Please ensure content complies with the Corporate Communications Policy.
                    </p>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="/posts" class="inline-flex justify-center py-2.5 px-5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2.5 px-5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Publish to Company Feed
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
