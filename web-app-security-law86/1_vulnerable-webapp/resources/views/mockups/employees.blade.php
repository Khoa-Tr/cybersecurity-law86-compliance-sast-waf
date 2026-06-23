@extends('layouts.app')
@section('title', 'Employees Directory')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Employees Directory</h1>
        <p class="mt-1 text-sm text-gray-500">Browse and manage all company employees.</p>
    </div>
    <div class="flex items-center gap-3">
        <button class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
            Filter
        </button>
        @if(session('role') === 'admin')
        <a href="{{ route('employee.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition">
            Add New Employee
        </a>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <!-- Mockup Data -->
    @php
        $mockEmployees = [
            ['name' => 'Admin User', 'role' => 'Management', 'email' => 'admin@company.com'],
            ['name' => 'John Doe', 'role' => 'Engineering', 'email' => 'john@example.com'],
            ['name' => 'Alice Smith', 'role' => 'Design', 'email' => 'alice@example.com'],
            ['name' => 'Bob Johnson', 'role' => 'Engineering', 'email' => 'bob@example.com'],
            ['name' => 'Charlie Brown', 'role' => 'AI & ML', 'email' => 'charlie@example.com'],
            ['name' => 'Diana Prince', 'role' => 'Marketing', 'email' => 'diana@example.com'],
            ['name' => 'Evan Wright', 'role' => 'Sales', 'email' => 'evan@example.com'],
            ['name' => 'Fiona Gallagher', 'role' => 'HR', 'email' => 'fiona@example.com'],
        ];
    @endphp

    @foreach($mockEmployees as $emp)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow p-6 flex flex-col items-center text-center">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($emp['name']) }}&background=random" alt="Avatar" class="w-20 h-20 rounded-full border-4 border-gray-50 mb-4">
        <h3 class="text-lg font-bold text-gray-900">{{ $emp['name'] }}</h3>
        <p class="text-sm font-medium text-indigo-600 mb-1">{{ $emp['role'] }}</p>
        <p class="text-xs text-gray-500 mb-4">{{ $emp['email'] }}</p>
        <div class="w-full pt-4 border-t border-gray-100 flex justify-center gap-4">
            <button class="text-gray-400 hover:text-indigo-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></button>
            <button class="text-gray-400 hover:text-indigo-600 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
        </div>
    </div>
    @endforeach
</div>
@endsection
