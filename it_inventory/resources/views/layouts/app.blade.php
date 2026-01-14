<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'IT Inventory') }} - @yield('title', 'Gestion de Parc Informatique')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Dark Mode Script - Must run before page render to prevent flash -->
        <script>
            (function() {
                const theme = localStorage.getItem('theme');
                if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="flex-1">
                <div class="py-8">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        @if(session('success'))
                            <div class="mb-6">
                                <x-alert type="success" :message="session('success')" />
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="mb-6">
                                <x-alert type="error" :message="session('error')" />
                            </div>
                        @endif

                {{ $slot }}
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="mt-auto border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center justify-between gap-3 sm:flex-row">
                        <div class="flex items-center gap-2.5">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-600 to-indigo-700">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">IT Inventory</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            &copy; {{ date('Y') }} IT Inventory. Tous droits réservés.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
