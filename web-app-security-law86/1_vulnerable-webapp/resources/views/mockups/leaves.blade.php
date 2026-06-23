@extends('layouts.app')
@section('title', 'Leaves & Time Off')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Leaves & Time Off</h1>
        <p class="mt-1 text-sm text-gray-500">Manage employee leave requests and balances.</p>
    </div>
    <div class="flex items-center gap-3">
        <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition">
            Request Leave
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col items-center text-center">
        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
        <p class="text-sm font-medium text-gray-500">Pending Requests</p>
        <p class="text-2xl font-bold text-gray-900">4</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col items-center text-center">
        <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <p class="text-sm font-medium text-gray-500">Approved This Month</p>
        <p class="text-2xl font-bold text-gray-900">12</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex flex-col items-center text-center">
        <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <p class="text-sm font-medium text-gray-500">People Currently on Leave</p>
        <p class="text-2xl font-bold text-gray-900">2</p>
    </div>
</div>

<div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-900">Recent Leave Requests</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-white">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Employee</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Leave Type</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Reason</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                    @if(session('role') === 'admin')
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-50">
                @php
                    $leaves = [
                        ['name' => 'Alice Smith', 'type' => 'Annual Leave', 'duration' => 'Jun 20 - Jun 22 (3 Days)', 'reason' => 'Family Vacation', 'status' => 'Approved', 'color' => 'green'],
                        ['name' => 'Charlie Brown', 'type' => 'Sick Leave', 'duration' => 'Jun 24 - Jun 24 (1 Day)', 'reason' => 'Medical Appointment', 'status' => 'Pending', 'color' => 'yellow'],
                        ['name' => 'Evan Wright', 'type' => 'Unpaid Leave', 'duration' => 'Jul 01 - Jul 05 (5 Days)', 'reason' => 'Personal Errands', 'status' => 'Pending', 'color' => 'yellow'],
                        ['name' => 'John Doe', 'type' => 'Annual Leave', 'duration' => 'May 10 - May 15 (5 Days)', 'reason' => 'Trip to Hawaii', 'status' => 'Rejected', 'color' => 'red'],
                    ];
                @endphp
                @foreach($leaves as $leave)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($leave['name']) }}&background=random" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-medium text-gray-900">{{ $leave['name'] }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $leave['type'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $leave['duration'] }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-[200px]">{{ $leave['reason'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $leave['color'] }}-50 text-{{ $leave['color'] }}-700 border border-{{ $leave['color'] }}-200">
                            {{ $leave['status'] }}
                        </span>
                    </td>
                    @if(session('role') === 'admin')
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($leave['status'] === 'Pending')
                        <button class="text-green-600 hover:text-green-900 mr-3">Approve</button>
                        <button class="text-red-600 hover:text-red-900">Reject</button>
                        @endif
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
