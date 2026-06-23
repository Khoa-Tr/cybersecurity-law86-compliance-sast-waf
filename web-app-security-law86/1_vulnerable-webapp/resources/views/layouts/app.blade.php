<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Corporate Portal') - HR & Payroll System</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        indigo: {
                            500: '#6366F1',
                            600: '#4F46E5', // Accent Color
                            700: '#4338CA',
                        },
                        gray: {
                            50: '#F8F9FA', // Base Background
                            100: '#F3F4F6',
                            800: '#1F2937', // Title text
                            600: '#4B5563', // Body text
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'Segoe UI', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #F8F9FA;
            color: #4B5563;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #1F2937;
        }
        /* Custom scrollbar for a polished look */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F3F4F6;
        }
        ::-webkit-scrollbar-thumb {
            background: #D1D5DB;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans antialiased text-gray-800">

@if(session('user_id'))
    @php
        // Fetch fresh user data to reflect avatar/role updates immediately
        $currentUser = \App\Models\User::find(session('user_id'));
    @endphp
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-full flex-shrink-0 shadow-sm">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <a href="/dashboard" class="flex items-center gap-2 text-indigo-600 font-bold text-xl tracking-tight">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Pagedone HR
            </a>
        </div>
        <!-- Menu -->
        <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-2 mt-4">Menu</p>
            <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->is('dashboard') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="/employees" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->is('employees') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Employees
            </a>
            <a href="/attendances" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->is('attendances') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Attendances
            </a>
            <a href="/calendar" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->is('calendar') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Calendar
            </a>
            <a href="/leaves" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition {{ request()->is('leaves') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Leaves
            </a>
            <a href="/posts" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50 font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                Announcements
            </a>
        </nav>
        <!-- User Info -->
        <div class="p-4 border-t border-gray-100">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-2">User</p>
            <a href="/profile/{{ session('user_id') }}" class="flex items-center gap-3 w-full hover:bg-gray-50 p-2 rounded-lg transition group border border-transparent hover:border-gray-200">
                @if($currentUser && $currentUser->avatar)
                    <img src="{{ $currentUser->avatar }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover bg-gray-200 shadow-sm border border-gray-100">
                @else
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold shadow-sm">
                        {{ strtoupper(substr(session('username'), 0, 1)) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $currentUser->name ?? session('username') }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ '@'.session('username') }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Header -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 z-10 shadow-sm">
            <div class="flex items-center gap-4">
                <h1 class="text-xl font-bold text-gray-900">Welcome back, {{ ucfirst($currentUser->name ?? session('username')) }}!</h1>
                <span class="text-sm text-gray-500 hidden sm:inline-block">Home</span>
            </div>
            <div class="flex items-center gap-4">
                <form action="/dashboard" method="GET" class="relative hidden md:block">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search here" class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 w-64 transition shadow-sm">
                    @if(request('department'))
                        <input type="hidden" name="department" value="{{ request('department') }}">
                    @endif
                </form>
                <!-- Admin specific button -->
                @if(session('role') === 'admin')
                <a href="{{ route('employee.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add Employee
                </a>
                @endif
                <a href="/logout" title="Sign Out" class="text-gray-500 hover:text-red-600 p-2 border border-transparent hover:bg-red-50 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </a>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6 lg:p-8">
            <!-- Toast Alerts -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
@else
    <!-- Guest Layout -->
    <main class="flex-1 w-full bg-gray-50 flex flex-col justify-center">
        @if(session('success'))
            <div class="absolute top-4 right-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg></div>
                    <div class="ml-3"><p class="text-sm font-medium text-green-800">{{ session('success') }}</p></div>
                </div>
            </div>
        @endif
        @if(session('info'))
            <div class="absolute top-4 right-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0"><svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg></div>
                    <div class="ml-3"><p class="text-sm font-medium text-blue-800">{{ session('info') }}</p></div>
                </div>
            </div>
        @endif
        @yield('content')
    </main>
@endif

<script>
// Format dates relative to now smoothly
function timeAgo(date) {
    const now = new Date();
    const diff = Math.floor((now - date) / 1000);
    if (diff < 60)      return 'Just now';
    if (diff < 3600)    return Math.floor(diff/60) + 'm ago';
    if (diff < 86400)   return Math.floor(diff/3600) + 'h ago';
    if (diff < 604800)  return Math.floor(diff/86400) + 'd ago';
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}
function updateTimestamps() {
    document.querySelectorAll('[data-timestamp]').forEach(el => {
        const ts = parseInt(el.getAttribute('data-timestamp'));
        if (ts) el.textContent = timeAgo(new Date(ts * 1000));
    });
}
updateTimestamps();
setInterval(updateTimestamps, 30000); // update every 30s
</script>
</body>
</html>
