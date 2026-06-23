@extends('layouts.app')
@section('title', 'Attendances')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Attendances</h1>
        <p class="mt-1 text-sm text-gray-500">Track employee time, attendance, and daily logs.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="bg-white border border-gray-200 rounded-lg p-1 flex items-center shadow-sm">
            <button class="px-4 py-1.5 text-sm font-medium rounded-md bg-indigo-50 text-indigo-700">Today</button>
            <button class="px-4 py-1.5 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">Week</button>
            <button class="px-4 py-1.5 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">Month</button>
        </div>
        <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition">
            Export Report
        </button>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <p class="text-sm font-medium text-gray-500 mb-1">Total Present</p>
        <p class="text-2xl font-bold text-gray-900">42 <span class="text-sm font-normal text-green-500">+2%</span></p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <p class="text-sm font-medium text-gray-500 mb-1">Total Absent</p>
        <p class="text-2xl font-bold text-gray-900">3 <span class="text-sm font-normal text-red-500">-1%</span></p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <p class="text-sm font-medium text-gray-500 mb-1">Late Arrivals</p>
        <p class="text-2xl font-bold text-gray-900">5 <span class="text-sm font-normal text-yellow-500">+1%</span></p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <p class="text-sm font-medium text-gray-500 mb-1">On Leave</p>
        <p class="text-2xl font-bold text-gray-900">2 <span class="text-sm font-normal text-gray-400">0%</span></p>
    </div>
</div>

<!-- Table -->
<div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-900">Today's Attendance Log</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-white">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Employee</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Check In</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Check Out</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-50">
                @php
                    $logs = [
                        ['name' => 'John Doe', 'date' => 'Jun 23, 2026', 'in' => '08:50 AM', 'out' => '--:--', 'status' => 'On Time', 'color' => 'green'],
                        ['name' => 'Alice Smith', 'date' => 'Jun 23, 2026', 'in' => '09:15 AM', 'out' => '--:--', 'status' => 'Late', 'color' => 'yellow'],
                        ['name' => 'Bob Johnson', 'date' => 'Jun 23, 2026', 'in' => '08:45 AM', 'out' => '--:--', 'status' => 'On Time', 'color' => 'green'],
                        ['name' => 'Charlie Brown', 'date' => 'Jun 23, 2026', 'in' => '--:--', 'out' => '--:--', 'status' => 'Absent', 'color' => 'red'],
                        ['name' => 'Diana Prince', 'date' => 'Jun 23, 2026', 'in' => '09:05 AM', 'out' => '--:--', 'status' => 'Late', 'color' => 'yellow'],
                    ];
                @endphp
                @foreach($logs as $log)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($log['name']) }}&background=random" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-medium text-gray-900">{{ $log['name'] }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log['date'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $log['in'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log['out'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $log['color'] }}-50 text-{{ $log['color'] }}-700 border border-{{ $log['color'] }}-200">
                            {{ $log['status'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
