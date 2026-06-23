@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Corporate Payroll & HR Overview</h1>
        <p class="mt-1 text-sm text-gray-500">Manage employee compensation, benefits, and departmental directories.</p>
    </div>
    <div class="flex items-center gap-3">
        <!-- Filter Form -->
        <form action="/dashboard" method="GET" class="flex items-center gap-2">
            <select name="department" class="border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white py-2 pl-3 pr-8 focus:outline-none focus:ring-1 focus:ring-indigo-500 transition" onchange="this.form.submit()">
                <option value="">All Departments</option>
                <option value="Engineering" {{ (isset($department) && $department == 'Engineering') ? 'selected' : '' }}>Engineering</option>
                <option value="Design" {{ (isset($department) && $department == 'Design') ? 'selected' : '' }}>Design</option>
                <option value="AI & ML" {{ (isset($department) && $department == 'AI & ML') ? 'selected' : '' }}>AI & ML</option>
                <option value="Management" {{ (isset($department) && $department == 'Management') ? 'selected' : '' }}>Management</option>
            </select>
        </form>
        <a href="{{ route('dashboard.export', ['department' => request('department'), 'search' => request('search')]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export CSV
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 transition-transform hover:-translate-y-1">
        <div class="h-12 w-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Total Employees</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalUsers ?? 5 }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 transition-transform hover:-translate-y-1">
        <div class="h-12 w-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Current Payroll Cycle</p>
            <p class="text-2xl font-bold text-gray-900">$124,500</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 transition-transform hover:-translate-y-1">
        <div class="h-12 w-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Active Announcements</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalPosts ?? 3 }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Employee Directory Table -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-900">Employee Payroll Directory</h3>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full border border-green-100">Cycle: Jun 2026</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Employee</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Department</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @foreach($allUsers as $u)
                        <tr class="hover:bg-indigo-50/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($u->avatar)
                                            <img src="{{ $u->avatar }}" alt="" class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                                {{ strtoupper(substr($u->username ?? $u->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ ucfirst($u->username ?? $u->name) }}</div>
                                        <div class="text-sm text-gray-500">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $u->department ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">ID: EMP-{{ str_pad($u->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($u->status === 'Active')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full text-green-700 bg-green-50 border border-green-200">
                                        Active
                                    </span>
                                @elseif($u->status === 'Inactive')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full text-red-700 bg-red-50 border border-red-200">
                                        Inactive
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full text-green-700 bg-green-50 border border-green-200">
                                        Active
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/profile/{{ $u->id }}" class="text-indigo-600 hover:text-indigo-900 font-semibold transition">View Payslip</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Announcements Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6 h-full flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900">Latest Updates</h3>
                <a href="/posts" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">View all</a>
            </div>
            <div class="space-y-6 flex-1">
                @forelse($recentPosts as $post)
                <div class="group cursor-pointer">
                    <a href="/posts/{{ $post->id }}">
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $post->title }}</h4>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                            <span>{{ ucfirst($post->user->username ?? $post->user->name ?? 'HR') }}</span>
                            <span>&bull;</span>
                            <span data-timestamp="{{ $post->created_at->timestamp }}">{{ $post->created_at->format('M d, Y') }}</span>
                        </p>
                    </a>
                </div>
                @empty
                <p class="text-sm text-gray-500">No updates yet.</p>
                @endforelse
            </div>
            
            @if(session('role') === 'admin' || auth()->user()?->role === 'admin')
            <div class="mt-6 pt-6 border-t border-gray-100">
                <a href="/posts/create" class="block w-full py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 text-center transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    + Publish Announcement
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
