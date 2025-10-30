<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>Register - TaskManager</title>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 min-h-screen flex items-center justify-center p-4 transition-colors">
    <div class="w-full max-w-md">        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Create Account</h2>                <button 
                    onclick="toggleDarkMode()"
                    class="px-3 py-1 rounded bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors text-sm font-medium text-gray-900 dark:text-white"
                    title="Toggle dark mode"
                >
                    <span class="light-mode">Dark</span>
                    <span class="dark-mode hidden">Light</span>
                </button>
            </div>

            @if ($errors->any())
                <div class="mb-4">
                    @foreach ($errors->all() as $error)
                        <div class="p-3 mb-2 rounded bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-100 text-sm">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" 
                           placeholder="Enter username">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" 
                           placeholder="Enter email">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" 
                           placeholder="Enter password">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required 
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" 
                           placeholder="Confirm password">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">Register</button>
            </form>

            <p class="text-center text-gray-600 dark:text-gray-400 text-sm mt-6">
                Already have an account? <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">Login here</a>
            </p>
        </div>
    </div>

    <script>        function toggleDarkMode() {
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
</body>
</html>
