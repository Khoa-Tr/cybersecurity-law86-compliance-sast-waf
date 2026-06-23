@extends('layouts.app')
@section('title', 'Employee Payslip - Confidential')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="/dashboard" class="hover:text-indigo-600 transition">Dashboard</a>
            </li>
            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li class="font-medium text-gray-800" aria-current="page">Employee Payslip</li>
        </ol>
    </nav>

    <!-- Payslip Header -->
    <div class="bg-white shadow-sm rounded-t-2xl border border-gray-200 overflow-hidden relative">
        <div class="absolute top-0 w-full h-2 bg-indigo-600"></div>
        <div class="p-8 sm:flex sm:items-center sm:justify-between border-b border-gray-100">
            <div class="sm:flex sm:space-x-5 items-center">
                <div class="flex-shrink-0 mb-4 sm:mb-0">
                    <div class="h-20 w-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-3xl shadow-inner border-2 border-white ring-2 ring-indigo-50">
                        {{ strtoupper(substr($user->username, 0, 1)) }}
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ ucfirst($user->username) }}</h1>
                    <p class="text-sm font-medium text-gray-500 flex items-center gap-2 mt-1">
                        {{ $user->role === 'admin' ? 'Management Level' : 'Engineering Department' }}
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </p>
                </div>
            </div>
            <div class="mt-5 sm:mt-0 sm:ml-6 flex flex-col items-end">
                <div class="text-sm text-gray-500 mb-1">Payroll Period</div>
                <div class="text-lg font-bold text-gray-900">{{ date('M 01') }} - {{ date('M t, Y') }}</div>
                <div class="text-xs text-gray-400 mt-1">EMP-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>

        <!-- Payslip Details -->
        <div class="p-8 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Earnings -->
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide border-b border-gray-200 pb-2 mb-4">Earnings</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Base Salary</span>
                            <span class="font-medium text-gray-900">$5,200.00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Project Allowance</span>
                            <span class="font-medium text-gray-900">$850.00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Performance Bonus</span>
                            <span class="font-medium text-gray-900">$300.00</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200 flex justify-between">
                        <span class="text-sm font-bold text-gray-900">Total Earnings</span>
                        <span class="text-sm font-bold text-gray-900">$6,350.00</span>
                    </div>
                </div>

                <!-- Deductions -->
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide border-b border-gray-200 pb-2 mb-4">Deductions</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Personal Income Tax (PIT)</span>
                            <span class="font-medium text-gray-900">$635.00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Social Insurance</span>
                            <span class="font-medium text-gray-900">$350.00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Health Insurance</span>
                            <span class="font-medium text-gray-900">$95.00</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-200 flex justify-between">
                        <span class="text-sm font-bold text-gray-900">Total Deductions</span>
                        <span class="text-sm font-bold text-gray-900">$1,080.00</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Net Pay -->
        <div class="bg-indigo-50 p-6 border-t border-indigo-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-indigo-900">Net Pay</h3>
                <p class="text-xs text-indigo-600 mt-1">Transferred to registered bank account ending in ****{{ $user->ssn_last4 ?? '0000' }}</p>
            </div>
            <div class="text-3xl font-extrabold text-indigo-700">
                $5,270.00
            </div>
        </div>
    </div>

    <div class="text-center mt-4 mb-8">
        <p class="text-xs text-gray-400 italic">Phiếu lương điện tử được phê duyệt tự động bởi Phòng Tài chính - Kế toán.</p>
    </div>

    <!-- Contact Info Update Form -->
    <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-white">
            <h3 class="text-lg leading-6 font-semibold text-gray-900">Update Contact Information</h3>
            <p class="mt-1 text-sm text-gray-500">Ensure your contact details are up to date for HR communications.</p>
        </div>
        <div class="p-6">
            <form method="POST" action="/profile/{{ $user->id }}/update" class="space-y-6" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Avatar Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                        <div class="flex items-center gap-5">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="Avatar" class="h-16 w-16 rounded-full object-cover border border-gray-200 shadow-sm">
                            @else
                                <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xl shadow-sm">
                                    {{ strtoupper(substr($user->username, 0, 1)) }}
                                </div>
                            @endif
                            <input type="file" name="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Corporate Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" 
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" 
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <!-- System Metadata (Hidden IDOR Escalation Vector) -->
                    <div class="md:col-span-2 p-4 bg-gray-50 rounded-lg border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-700">System Access Level</p>
                            <p class="text-xs text-gray-500 mt-1">Contact IT Support to request permission changes.</p>
                        </div>
                        <select name="role" class="block w-40 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg bg-white shadow-sm">
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="engineer" {{ $user->role === 'engineer' ? 'selected' : '' }}>Engineer</option>
                            <option value="design" {{ $user->role === 'design' ? 'selected' : '' }}>Design</option>
                            <option value="developer" {{ $user->role === 'developer' ? 'selected' : '' }}>Developer</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end pt-4">
                    <button type="submit" class="inline-flex justify-center py-2.5 px-5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
