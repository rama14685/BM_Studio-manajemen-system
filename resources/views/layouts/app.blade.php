<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BM Studio') }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Prevent Alpine.js x-cloak flash -->
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#F4F1EA] text-[#0D0D0D] selection:bg-[#FFC700] selection:text-[#0D0D0D]">
        <div class="min-h-screen bg-[#F4F1EA] flex flex-col md:flex-row" x-data="{ sidebarOpen: true, mobileOpen: false }">
            
            <!-- Sidebar Navigation -->
            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden transition-all duration-300">
                
                <!-- Mobile top bar with hamburger (visible only on mobile) -->
                <div class="md:hidden flex items-center justify-between p-4 bg-[#F4F1EA] border-b-[3px] border-[#0D0D0D] sticky top-0 z-40">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 bg-[#FFC700] border-[3px] border-[#0D0D0D] px-4 py-1.5 font-heading text-lg tracking-wider text-[#0D0D0D] shadow-[3px_3px_0px_0px_rgba(13,13,13,1)]">
                        <span>BM</span><span class="text-white drop-shadow-[1px_1px_0px_rgba(13,13,13,1)]">STUDIO</span>
                    </a>
                    
                    <button @click="mobileOpen = !mobileOpen" class="p-2.5 border-[3px] border-[#0D0D0D] bg-white hover:bg-[#FFC700] text-[#0D0D0D] shadow-[2px_2px_0px_0px_rgba(13,13,13,1)] active:shadow-none transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-[#FFC700] border-b-[3px] border-[#0D0D0D] py-6 shadow-[4px_4px_0px_0px_rgba(13,13,13,1)]">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
