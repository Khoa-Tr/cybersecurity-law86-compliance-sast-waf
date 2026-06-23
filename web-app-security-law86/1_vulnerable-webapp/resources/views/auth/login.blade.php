<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - NexusHR Enterprise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        indigo: { 500: '#6366F1', 600: '#4F46E5', 700: '#4338CA' },
                        gray: { 50: '#F8F9FA', 100: '#F3F4F6', 800: '#1F2937', 600: '#4B5563' }
                    },
                    fontFamily: { sans: ['Inter', 'Segoe UI', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { background-color: #F8F9FA; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans antialiased text-gray-600">

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center text-indigo-600 mb-2">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </div>
        <h2 class="mt-2 text-center text-3xl font-extrabold text-gray-800 tracking-tight">
            NexusHR
        </h2>
        <p class="mt-2 text-center text-sm text-gray-500">
            Enterprise Human Resource Management
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-sm sm:rounded-2xl sm:px-10 border border-gray-100">
            
            @if(session('error') || $errors->any())
                <!-- Enterprise Alert Component -->
                <div class="mb-6 bg-red-50 border-l-4 border-red-600 p-4 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">Thông tin đăng nhập không chính xác. Xin vui lòng thử lại.</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form class="space-y-6" action="/login" method="POST">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Corporate Employee ID</label>
                    <div class="mt-1">
                        <input id="username" name="username" type="text" autocomplete="off" required 
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                            placeholder="e.g. admin or john">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Secure Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required 
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            Remember my device
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 transition">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        Secure Sign In
                    </button>
                </div>
            </form>
        </div>
        
        <p class="mt-6 text-center text-xs text-gray-500">
            Bằng việc đăng nhập, bạn đồng ý với Chính sách Bảo mật Dữ liệu Nội bộ của Công ty.<br>
            &copy; {{ date('Y') }} NexusHR Enterprise System.
        </p>
    </div>

</body>
</html>
