<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - BM Studio</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets (Tailwind) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-heading {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
        }
    </style>
</head>
<body class="bg-[#F4F1EA] text-[#0D0D0D] min-h-screen antialiased selection:bg-[#FFC700] selection:text-[#0D0D0D]">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- 1. LEFT PANEL: MUSIC IMAGE & OVERLAY (Visible on md and up) -->
        <div class="hidden md:flex md:w-1/2 relative bg-[#0D0D0D] items-center justify-center overflow-hidden border-r-[3px] border-[#0D0D0D]">
            <!-- Background Image -->
            <img src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?auto=format&fit=crop&w=1000&q=80" alt="Concert Stage" class="absolute w-full h-full object-cover opacity-60">
            
            <!-- Faded Terracotta Red / Stark Black Overlay -->
            <div class="absolute inset-0 bg-gradient-to-tr from-[#0D0D0D] via-[#0D0D0D]/75 to-[#E14D2A]/50"></div>

            <!-- Quote Context -->
            <div class="relative z-10 p-12 max-w-lg space-y-6">
                <div class="flex items-center space-x-2">
                    <span class="text-4xl font-heading text-[#FFC700] drop-shadow-[2px_2px_0px_rgba(13,13,13,1)]">BM</span>
                    <span class="text-2xl font-bold uppercase tracking-widest text-white">Studio</span>
                </div>
                <blockquote class="text-3xl font-heading text-white uppercase leading-tight drop-shadow-[2px_2px_0px_rgba(13,13,13,1)]">
                    "TULISKAN SEJARAH GRUP MUSIKMU MULAI DARI SINI."
                </blockquote>
                <p class="text-sm font-heading tracking-wider uppercase text-[#FFC700]">&mdash; BM Crew</p>
            </div>
        </div>

        <!-- 2. RIGHT PANEL: REGISTER FORM (Full height) -->
        <div class="flex-1 flex flex-col justify-between p-8 sm:p-12 md:p-16 lg:p-24 bg-[#F4F1EA] h-screen overflow-y-auto">
            
            <!-- Top bar -->
            <div class="flex items-center justify-between">
                <a href="/" class="inline-flex items-center text-sm text-[#0D0D0D] hover:text-[#E14D2A] transition font-bold">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                </a>
                <span class="text-xs text-zinc-500 font-mono font-bold">BM-STUDIO v2.5</span>
            </div>

            <!-- Main Form Card -->
            <div class="my-auto max-w-md w-full mx-auto space-y-8 pt-8 pb-8">
                <div>
                    <h2 class="text-4xl font-heading uppercase tracking-wider text-[#0D0D0D] drop-shadow-[2px_2px_0px_rgba(255,199,0,1)]">DAFTAR ANGGOTA</h2>
                    <p class="text-sm text-zinc-700 font-bold mt-2">Daftarkan band Anda untuk memesan studio musik terbaik.</p>
                </div>

                <!-- Error Alert -->
                @if($errors->any())
                    <div class="p-4 bg-[#E14D2A] border-[3px] border-black text-white text-xs font-bold shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>&#10006; {{ strtoupper($error) }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="/register" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-1.5">
                        <x-input-label for="name" :value="__('Nama Lengkap / Nama Band')" class="text-[#0D0D0D] font-bold text-xs" />
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            placeholder="Band / Nama Anda"
                            class="w-full bg-white border-[3px] border-[#0D0D0D] rounded-none px-4 py-2.5 text-sm text-[#0D0D0D] focus:outline-none focus:ring-0 focus:border-[#FFC700] focus:bg-[#F4F1EA] transition-all duration-150 shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] focus:shadow-none focus:translate-x-0.5 focus:translate-y-0.5">
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-1.5">
                        <x-input-label for="email" :value="__('Email')" class="text-[#0D0D0D] font-bold text-xs" />
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                            placeholder="nama@email.com"
                            class="w-full bg-white border-[3px] border-[#0D0D0D] rounded-none px-4 py-2.5 text-sm text-[#0D0D0D] focus:outline-none focus:ring-0 focus:border-[#FFC700] focus:bg-[#F4F1EA] transition-all duration-150 shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] focus:shadow-none focus:translate-x-0.5 focus:translate-y-0.5">
                    </div>

                    <!-- Phone Number -->
                    <div class="space-y-1.5">
                        <x-input-label for="phone" :value="__('No. Telepon / WhatsApp')" class="text-[#0D0D0D] font-bold text-xs" />
                        <input id="phone" type="text" name="phone" :value="old('phone')" required placeholder="Contoh: 08123456789"
                            class="w-full bg-white border-[3px] border-[#0D0D0D] rounded-none px-4 py-2.5 text-sm text-[#0D0D0D] focus:outline-none focus:ring-0 focus:border-[#FFC700] focus:bg-[#F4F1EA] transition-all duration-150 shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] focus:shadow-none focus:translate-x-0.5 focus:translate-y-0.5">
                    </div>

                    <!-- Password -->
                    <div class="space-y-1.5">
                        <x-input-label for="password" :value="__('Password')" class="text-[#0D0D0D] font-bold text-xs" />
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full bg-white border-[3px] border-[#0D0D0D] rounded-none px-4 py-2.5 text-sm text-[#0D0D0D] focus:outline-none focus:ring-0 focus:border-[#FFC700] focus:bg-[#F4F1EA] transition-all duration-150 shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] focus:shadow-none focus:translate-x-0.5 focus:translate-y-0.5">
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-[#0D0D0D] font-bold text-xs" />
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ketik ulang password"
                            class="w-full bg-white border-[3px] border-[#0D0D0D] rounded-none px-4 py-2.5 text-sm text-[#0D0D0D] focus:outline-none focus:ring-0 focus:border-[#FFC700] focus:bg-[#F4F1EA] transition-all duration-150 shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] focus:shadow-none focus:translate-x-0.5 focus:translate-y-0.5">
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full py-4 bg-[#E14D2A] border-[3px] border-[#0D0D0D] text-white font-heading text-sm uppercase tracking-widest shadow-[4px_4px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">
                            DAFTAR SEKARANG
                        </button>
                    </div>
                </form>

                <div class="text-center text-sm font-bold text-zinc-600">
                    Sudah punya akun? 
                    <a href="/login" class="text-[#E14D2A] hover:underline font-bold transition">Masuk di sini</a>
                </div>
            </div>

            <!-- Footer terms -->
            <div class="text-center text-[10px] text-zinc-500 font-heading tracking-wider">
                BM STUDIO MUSIK &copy; 2026. LATIHAN MAKSIMAL, MUSIK BERKELAS.
            </div>

        </div>

    </div>

</body>
</html>
