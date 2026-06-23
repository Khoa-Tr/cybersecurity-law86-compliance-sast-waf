@extends('layouts.app')
@section('title', 'Calendar')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Company Calendar</h1>
        <p class="mt-1 text-sm text-gray-500">View upcoming events, holidays, and team schedules.</p>
    </div>
    <div class="flex items-center gap-3">
        @if(session('role') === 'admin')
        <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition">
            Add Event
        </button>
        @endif
    </div>
</div>

<div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-900">June 2026</h2>
        <div class="flex items-center gap-2">
            <button class="p-2 border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
            <button class="p-2 border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
        </div>
    </div>
    
    <div class="grid grid-cols-7 gap-px bg-gray-200 border border-gray-200 rounded-lg overflow-hidden">
        <!-- Days -->
        <div class="bg-gray-50 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Sun</div>
        <div class="bg-gray-50 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Mon</div>
        <div class="bg-gray-50 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Tue</div>
        <div class="bg-gray-50 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Wed</div>
        <div class="bg-gray-50 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Thu</div>
        <div class="bg-gray-50 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Fri</div>
        <div class="bg-gray-50 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Sat</div>

        <!-- Dates (Mockup) -->
        @for($i = 1; $i <= 30; $i++)
            <div class="bg-white min-h-[100px] p-2 hover:bg-gray-50 transition relative group">
                <span class="text-sm font-medium {{ $i == 23 ? 'bg-indigo-600 text-white rounded-full w-6 h-6 flex items-center justify-center' : 'text-gray-700' }}">{{ $i }}</span>
                
                @if($i == 14)
                <div class="mt-1 px-2 py-1 text-xs rounded bg-blue-50 text-blue-700 border border-blue-100 truncate">
                    Team Meeting
                </div>
                @endif
                
                @if($i == 20)
                <div class="mt-1 px-2 py-1 text-xs rounded bg-green-50 text-green-700 border border-green-100 truncate">
                    Alice - Annual Leave
                </div>
                @endif
                
                @if($i == 25)
                <div class="mt-1 px-2 py-1 text-xs rounded bg-red-50 text-red-700 border border-red-100 truncate">
                    Company Holiday
                </div>
                @endif
            </div>
        @endfor
        
        <!-- Empty slots to fill the grid -->
        @for($i = 1; $i <= 5; $i++)
            <div class="bg-gray-50/50 min-h-[100px] p-2"></div>
        @endfor
    </div>
</div>
@endsection
