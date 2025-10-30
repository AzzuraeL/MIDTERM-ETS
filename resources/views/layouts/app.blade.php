<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html-root">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {}
            }
        }
    </script>
    <script>
        // Initialize dark mode from localStorage
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen transition-colors">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                        Task Manager
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 dark:text-gray-300">Hello, {{ auth()->user()->username ?? auth()->user()->name ?? 'User' }}!</span>                    <!-- Dark Mode Toggle -->
                    <button 
                        onclick="toggleDarkMode()"
                        class="px-3 py-1 rounded bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors text-sm font-medium text-gray-900 dark:text-white"
                        title="Toggle dark mode"
                        id="theme-toggle"
                    >
                        <span class="light-mode">Dark</span>
                        <span class="dark-mode hidden">Light</span>
                    </button>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            @yield('content')
        </div>
    </div>    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            const lightMode = document.querySelector('.light-mode');
            const darkMode = document.querySelector('.dark-mode');
            
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if (lightMode) lightMode.classList.remove('hidden');
                if (darkMode) darkMode.classList.add('hidden');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (lightMode) lightMode.classList.add('hidden');
                if (darkMode) darkMode.classList.remove('hidden');
            }
        }
        
        // Initialize button text on page load
        document.addEventListener('DOMContentLoaded', function() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            const lightMode = document.querySelector('.light-mode');
            const darkMode = document.querySelector('.dark-mode');
            
            if (isDark) {
                if (lightMode) lightMode.classList.add('hidden');
                if (darkMode) darkMode.classList.remove('hidden');
            } else {
                if (lightMode) lightMode.classList.remove('hidden');
                if (darkMode) darkMode.classList.add('hidden');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
