<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BM Studio - Rental Studio Band & Musik</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&family=Syne:wght@800&display=swap" rel="stylesheet">
    
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
        /* Custom hide utilities for fallback */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F4F1EA] text-[#0D0D0D] min-h-screen antialiased flex flex-col justify-between selection:bg-[#FFC700] selection:text-[#0D0D0D] overflow-x-hidden">

    <!-- FLOATING PARALLAX ELEMENTS WRAPPER (Z-10) -->
    <div class="fixed inset-0 pointer-events-none z-10 overflow-hidden">
        <!-- Floating Electric Guitar -->
        <div id="floating-guitar" class="absolute top-0 left-0 transition-transform duration-75 ease-out will-change-transform opacity-90 drop-shadow-[4px_4px_0px_rgba(13,13,13,1)]">
            <svg class="w-48 h-48 sm:w-72 sm:h-72" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Guitar Neck -->
                <rect x="88" y="30" width="8" height="95" fill="#FFC700" stroke="#0D0D0D" stroke-width="3"/>
                <!-- Fret board lines -->
                <line x1="88" y1="42" x2="96" y2="42" stroke="#0D0D0D" stroke-width="2.5"/>
                <line x1="88" y1="58" x2="96" y2="58" stroke="#0D0D0D" stroke-width="2.5"/>
                <line x1="88" y1="74" x2="96" y2="74" stroke="#0D0D0D" stroke-width="2.5"/>
                <line x1="88" y1="90" x2="96" y2="90" stroke="#0D0D0D" stroke-width="2.5"/>
                <line x1="88" y1="106" x2="96" y2="106" stroke="#0D0D0D" stroke-width="2.5"/>
                <!-- Guitar Headstock -->
                <path d="M85 10 L 82 30 L 98 30 L 98 15 C 98 8, 85 5, 85 10 Z" fill="#E14D2A" stroke="#0D0D0D" stroke-width="3.5"/>
                <!-- Tuning Pegs -->
                <circle cx="78" cy="14" r="3.5" fill="#0D0D0D"/>
                <circle cx="78" cy="22" r="3.5" fill="#0D0D0D"/>
                <circle cx="102" cy="14" r="3.5" fill="#0D0D0D"/>
                <circle cx="102" cy="22" r="3.5" fill="#0D0D0D"/>
                <!-- Guitar Body -->
                <path d="M68 115 C 45 95, 25 125, 35 155 C 45 185, 80 190, 95 183 C 110 178, 128 185, 138 168 C 148 150, 138 115, 115 115 C 100 115, 95 122, 90 122 C 85 122, 80 115, 68 115 Z" fill="#E14D2A" stroke="#0D0D0D" stroke-width="4.5"/>
                <!-- Guitar Pickguard -->
                <path d="M78 126 C 65 120, 55 130, 60 148 C 65 166, 88 172, 93 165 C 98 158, 93 135, 83 130 Z" fill="#FFFFFF" stroke="#0D0D0D" stroke-width="3"/>
                <!-- Guitar Pickups -->
                <rect x="78" y="140" width="20" height="7" rx="1.5" fill="#FFC700" stroke="#0D0D0D" stroke-width="2.5" />
                <rect x="78" y="152" width="20" height="7" rx="1.5" fill="#0D0D0D" stroke="#FFFFFF" stroke-width="1.5" />
                <circle cx="85" cy="168" r="4.5" fill="#FFC700" stroke="#0D0D0D" stroke-width="2"/>
                <circle cx="95" cy="168" r="4.5" fill="#FFC700" stroke="#0D0D0D" stroke-width="2"/>
                <!-- Strings -->
                <line x1="90" y1="20" x2="90" y2="140" stroke="#0D0D0D" stroke-width="1.5"/>
                <line x1="92" y1="20" x2="92" y2="140" stroke="#0D0D0D" stroke-width="1.5"/>
                <line x1="94" y1="20" x2="94" y2="140" stroke="#0D0D0D" stroke-width="1.5"/>
            </svg>
        </div>

        <!-- Floating Drum Kit -->
        <div id="floating-drums" class="absolute top-0 left-0 transition-transform duration-75 ease-out will-change-transform opacity-90 drop-shadow-[4px_4px_0px_rgba(13,13,13,1)]">
            <svg class="w-48 h-48 sm:w-72 sm:h-72" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Bass Drum Leg Left -->
                <line x1="65" y1="140" x2="45" y2="185" stroke="#0D0D0D" stroke-width="6" stroke-linecap="round"/>
                <!-- Bass Drum Leg Right -->
                <line x1="135" y1="140" x2="155" y2="185" stroke="#0D0D0D" stroke-width="6" stroke-linecap="round"/>
                <!-- Bass Drum -->
                <circle cx="100" cy="125" r="42" fill="#FFC700" stroke="#0D0D0D" stroke-width="5"/>
                <circle cx="100" cy="125" r="33" fill="#FFFFFF" stroke="#0D0D0D" stroke-width="3.5"/>
                <!-- Bass Drum Logo Text placeholder -->
                <text x="100" y="130" font-family="'Syne', sans-serif" font-size="10" font-weight="900" fill="#0D0D0D" text-anchor="middle" letter-spacing="1">BM</text>

                <!-- Tom Tom Left -->
                <rect x="63" y="62" width="32" height="22" rx="2" fill="#E14D2A" stroke="#0D0D0D" stroke-width="3.5"/>
                <line x1="63" y1="67" x2="95" y2="67" stroke="#0D0D0D" stroke-width="2.5"/>
                <line x1="63" y1="79" x2="95" y2="79" stroke="#0D0D0D" stroke-width="2.5"/>
                
                <!-- Tom Tom Right -->
                <rect x="105" y="62" width="32" height="22" rx="2" fill="#E14D2A" stroke="#0D0D0D" stroke-width="3.5"/>
                <line x1="105" y1="67" x2="137" y2="67" stroke="#0D0D0D" stroke-width="2.5"/>
                <line x1="105" y1="79" x2="137" y2="79" stroke="#0D0D0D" stroke-width="2.5"/>

                <!-- Tom Holders / Hardware -->
                <path d="M78 84 L 78 95 L 90 95" stroke="#0D0D0D" stroke-width="3.5" fill="none" stroke-linejoin="round"/>
                <path d="M122 84 L 122 95 L 110 95" stroke="#0D0D0D" stroke-width="3.5" fill="none" stroke-linejoin="round"/>
                <rect x="94" y="93" width="12" height="6" fill="#0D0D0D" />

                <!-- Snare Drum Left -->
                <rect x="25" y="88" width="34" height="16" rx="2" fill="#FFFFFF" stroke="#0D0D0D" stroke-width="3.5"/>
                <line x1="25" y1="92" x2="59" y2="92" stroke="#0D0D0D" stroke-width="2"/>
                <line x1="25" y1="100" x2="59" y2="100" stroke="#0D0D0D" stroke-width="2"/>
                <!-- Snare Stand -->
                <line x1="42" y1="104" x2="42" y2="175" stroke="#0D0D0D" stroke-width="3.5"/>
                <line x1="42" y1="175" x2="28" y2="188" stroke="#0D0D0D" stroke-width="3.5" stroke-linecap="round"/>
                <line x1="42" y1="175" x2="56" y2="188" stroke="#0D0D0D" stroke-width="3.5" stroke-linecap="round"/>

                <!-- Cymbal Crash Right -->
                <path d="M135 52 C 135 48, 175 48, 175 52 Z" fill="#FFC700" stroke="#0D0D0D" stroke-width="3.5"/>
                <!-- Cymbal Stand -->
                <line x1="155" y1="52" x2="155" y2="175" stroke="#0D0D0D" stroke-width="3.5"/>
                <line x1="155" y1="175" x2="142" y2="188" stroke="#0D0D0D" stroke-width="3.5" stroke-linecap="round"/>
                <line x1="155" y1="175" x2="168" y2="188" stroke="#0D0D0D" stroke-width="3.5" stroke-linecap="round"/>
            </svg>
        </div>
    </div>

    <!-- HEADER NAVIGATION (Z-50) -->
    <header class="border-b-[3px] border-[#0D0D0D] bg-[#F4F1EA] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <a href="/" class="flex items-center space-x-1 bg-[#FFC700] border-[3px] border-[#0D0D0D] px-4 py-1.5 font-heading text-lg tracking-wider text-[#0D0D0D] shadow-[3px_3px_0px_0px_rgba(13,13,13,1)]">
                    <span>BM</span><span class="text-white drop-shadow-[1px_1px_0px_rgba(13,13,13,1)]">STUDIO</span>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-[#FFC700] border-[3px] border-[#0D0D0D] font-heading text-sm uppercase tracking-wider text-[#0D0D0D] shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                        Dashboard &rarr;
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 border-[3px] border-[#0D0D0D] text-[#0D0D0D] bg-white hover:bg-[#FFC700] transition text-sm font-heading uppercase tracking-wider shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-[#E14D2A] border-[3px] border-[#0D0D0D] text-white font-heading text-sm uppercase tracking-wider shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- CONTENT SECTIONS (Z-20) -->
    <main class="flex-grow space-y-16 pb-20 relative z-20">

        <!-- 1. HERO SECTION -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 text-center space-y-6 relative">
            <div class="inline-flex items-center space-x-2 bg-[#FFC700] border-[3px] border-[#0D0D0D] px-6 py-2.5 font-heading text-sm uppercase text-[#0D0D0D] tracking-widest shadow-[3.5px_3.5px_0px_0px_rgba(13,13,13,1)]">
                <span>⚡ ROCK AND ROLL MUSIC HUB</span>
            </div>
            
            <h1 class="text-6xl sm:text-9xl font-heading uppercase tracking-tighter text-[#0D0D0D] max-w-5xl mx-auto leading-[0.85] drop-shadow-[5px_5px_0px_#FFC700]">
                LOUDER.<br>BETTER.<br><span class="text-[#E14D2A]">YOUR STAGE.</span>
            </h1>
            
            <p class="text-base sm:text-xl text-[#0D0D0D] max-w-2xl mx-auto font-extrabold leading-relaxed pt-2">
                Mainkan musikmu tanpa kompromi. Gear panggung premium, studio kedap suara maksimal, dan booking slot instan kapan saja.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-10 py-5 bg-[#FFC700] border-[3px] border-[#0D0D0D] text-[#0D0D0D] font-heading text-md uppercase tracking-wider shadow-[5px_5px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all text-center">
                        BUKA DASHBOARD ANDA
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-5 bg-[#E14D2A] border-[3px] border-[#0D0D0D] text-white font-heading text-md uppercase tracking-wider shadow-[5px_5px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all text-center">
                        BOOK STUDIO NOW
                    </a>
                @endauth
            </div>

            <!-- Central Open Spacing Placeholder where 3D Guitar and Drums float -->
            <div class="h-16 sm:h-24 w-full flex items-center justify-center select-none">
            </div>
        </section>

        <!-- 2. STUDIO GALLERY CAROUSEL (DYNAMIC COVERFLOW) -->
        <section id="studio-gallery" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-2 relative z-30" 
            x-data="{ 
                activeSlide: {{ count($carouselItems) > 0 ? floor(count($carouselItems) / 2) : 0 }},
                totalSlides: {{ count($carouselItems) }},
                scrollNext() { 
                    if (this.activeSlide < this.totalSlides - 1) this.activeSlide++; 
                    else this.activeSlide = 0; 
                }, 
                scrollPrev() { 
                    if (this.activeSlide > 0) this.activeSlide--; 
                    else this.activeSlide = this.totalSlides - 1; 
                } 
            }">
            <div class="border-[3px] border-[#0D0D0D] bg-white p-6 shadow-[5px_5px_0px_0px_#0D0D0D]">
                <div class="flex justify-between items-center mb-6 border-b-[3px] border-black pb-4">
                    <div>
                        <h2 class="text-3xl sm:text-4xl font-heading uppercase tracking-wider text-[#0D0D0D] drop-shadow-[1.5px_1.5px_0px_#FFC700]">
                            ⚡ STUDIO ROOMS GALLERY ⚡
                        </h2>
                        <p class="text-[10px] sm:text-xs text-zinc-650 font-bold uppercase tracking-widest mt-1">Eksplorasi studio latihan & rekaman profesional kami (CMS Dynamic Coverflow)</p>
                    </div>
                    <!-- Navigation Buttons -->
                    <div class="flex space-x-3">
                        <button @click="scrollPrev()" class="p-3 border-[3px] border-[#0D0D0D] bg-[#FFC700] hover:bg-[#E14D2A] text-black hover:text-white font-black text-sm shadow-[2px_2px_0px_0px_#0D0D0D] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all cursor-pointer">
                            &larr;
                        </button>
                        <button @click="scrollNext()" class="p-3 border-[3px] border-[#0D0D0D] bg-[#E14D2A] hover:bg-[#FFC700] text-white hover:text-black font-black text-sm shadow-[2px_2px_0px_0px_#0D0D0D] active:translate-x-0.5 active:translate-y-0.5 active:shadow-none transition-all cursor-pointer">
                            &rarr;
                        </button>
                    </div>
                </div>

                <!-- Coverflow Container -->
                <div class="relative w-full h-[380px] sm:h-[460px] flex items-center justify-center overflow-hidden bg-[#F4F1EA] border-[3px] border-black shadow-[3px_3px_0px_0px_black]">
                    @if(count($carouselItems) === 0)
                        <p class="font-mono text-zinc-500 font-bold">[ BELUM ADA DATA CAROUSEL CMS ]</p>
                    @else
                        @foreach($carouselItems as $idx => $item)
                            <div 
                                x-show="activeSlide === {{ $idx }} || activeSlide - 1 === {{ $idx }} || activeSlide + 1 === {{ $idx }} || (activeSlide === 0 && {{ $idx }} === totalSlides - 1) || (activeSlide === totalSlides - 1 && {{ $idx }} === 0)"
                                :class="{
                                    'scale-100 sm:scale-105 z-30 opacity-100 border-[#E14D2A] shadow-[6px_6px_0px_0px_rgba(13,13,13,1)]': activeSlide === {{ $idx }},
                                    'scale-85 sm:scale-90 z-20 opacity-60 border-[#0D0D0D] shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] -translate-x-32 sm:-translate-x-48 -rotate-6': (activeSlide > {{ $idx }} && !(activeSlide === totalSlides - 1 && {{ $idx }} === 0)) || (activeSlide === 0 && {{ $idx }} === totalSlides - 1),
                                    'scale-85 sm:scale-90 z-20 opacity-60 border-[#0D0D0D] shadow-[3px_3px_0px_0px_rgba(13,13,13,1)] translate-x-32 sm:translate-x-48 rotate-6': (activeSlide < {{ $idx }} && !(activeSlide === 0 && {{ $idx }} === totalSlides - 1)) || (activeSlide === totalSlides - 1 && {{ $idx }} === 0)
                                }"
                                class="transition-all duration-300 ease-out absolute bg-white border-[3px] p-4 w-[260px] sm:w-[360px] h-[320px] sm:h-[400px] flex-shrink-0 cursor-pointer select-none"
                                @click="activeSlide = {{ $idx }}"
                            >
                                <div class="overflow-hidden border-[3px] border-black h-36 sm:h-52 mb-4 bg-zinc-900 flex items-center justify-center">
                                    <img src="{{ $item->image_path }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex justify-between items-center border-b-2 border-black/10 pb-2 mb-2 font-heading">
                                    <h3 class="text-sm sm:text-base uppercase text-black">{{ $item->title }}</h3>
                                    <span class="px-2 py-0.5 text-[8px] bg-[#FFC700] border-2 border-black shadow-[1px_1px_0px_0px_black] uppercase font-bold text-black">CMS ITEM</span>
                                </div>
                                <p class="text-[11px] text-zinc-650 font-bold leading-normal text-ellipsis overflow-hidden h-12">{{ $item->description }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <!-- 3. PRICING/PACKAGES SECTION (SWAPPED TO FIRST POSITION) -->
        <section id="pricing-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 relative">
            <div class="text-center space-y-2">
                <h2 class="text-4xl sm:text-5xl font-heading uppercase tracking-wider text-[#0D0D0D] drop-shadow-[2px_2px_0px_#FFC700]">
                    💰 STUDIO PACKAGES 💰
                </h2>
                <p class="text-xs sm:text-sm text-zinc-650 font-bold uppercase tracking-widest">Tarif transparan flat bersahabat untuk latihan band dan recording</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                <!-- Package 1: Hourly Jam -->
                <div class="bg-white border-[3px] border-[#0D0D0D] p-8 shadow-[5px_5px_0px_0px_#0D0D0D] flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <span class="px-3 py-1 border-2 border-black bg-white text-black font-heading text-[10px] uppercase tracking-wider shadow-[1.5px_1.5px_0px_0px_black]">STUDIO KECIL</span>
                        <h3 class="text-3xl font-heading uppercase">Hourly Jam</h3>
                        <p class="text-xs text-zinc-650 font-bold leading-relaxed">Sangat cocok untuk latihan rutin band kecil 3-5 personil dengan tarif per jam.</p>
                        
                        <div class="border-t border-black/10 pt-4 font-heading text-3xl text-black">
                            Rp 50.000 <span class="text-xs font-sans font-bold text-zinc-500">/ Jam</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('register') }}" class="w-full inline-flex justify-center items-center py-3 bg-[#FFC700] hover:bg-black hover:text-white border-[2.5px] border-black text-black font-heading text-xs uppercase tracking-wider shadow-[2.5px_2.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                        BOOKING SLOT &rarr;
                    </a>
                </div>

                <!-- Package 2: Hourly Big Jam -->
                <div class="bg-[#FFC700] border-[3px] border-[#0D0D0D] p-8 shadow-[5px_5px_0px_0px_#0D0D0D] flex flex-col justify-between space-y-6 transform scale-100 md:scale-105 relative z-10">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#E14D2A] text-white border-2 border-black font-heading text-[9px] py-1 px-4 uppercase tracking-widest shadow-[2px_2px_0px_0px_black] whitespace-nowrap">
                        BEST DEAL / POPULER
                    </div>
                    
                    <div class="space-y-4">
                        <span class="px-3 py-1 border-2 border-black bg-white text-black font-heading text-[10px] uppercase tracking-wider shadow-[1.5px_1.5px_0px_0px_black]">STUDIO BESAR</span>
                        <h3 class="text-3xl font-heading uppercase">Big Jam</h3>
                        <p class="text-xs text-black font-bold leading-relaxed">Sangat cocok untuk latihan band besar 5-8 personil dengan peralatan panggung kelas premium.</p>
                        
                        <div class="border-t border-black/10 pt-4 font-heading text-3xl text-black">
                            Rp 80.000 <span class="text-xs font-sans font-bold text-zinc-800">/ Jam</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('register') }}" class="w-full inline-flex justify-center items-center py-3 bg-[#E14D2A] hover:bg-black hover:text-white border-[2.5px] border-black text-white font-heading text-xs uppercase tracking-wider shadow-[2.5px_2.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                        BOOKING SEKARANG &rarr;
                    </a>
                </div>

                <!-- Package 3: Full Day Recording -->
                <div class="bg-[#E14D2A] border-[3px] border-[#0D0D0D] p-8 shadow-[5px_5px_0px_0px_#0D0D0D] text-white flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <span class="px-3 py-1 border-2 border-2 border-black bg-white text-black font-heading text-[10px] uppercase tracking-wider shadow-[1.5px_1.5px_0px_0px_black]">FULL RECORDING</span>
                        <h3 class="text-3xl font-heading uppercase text-white">Pro Session</h3>
                        <p class="text-xs text-white/95 font-bold leading-relaxed">Sewa studio penuh satu hari lengkap dengan operator sound engineer untuk multitrack tracking.</p>
                        
                        <div class="border-t border-white/20 pt-4 font-heading text-3xl text-white">
                            Rp 1.000.000 <span class="text-xs font-sans font-bold text-white/80">/ Hari</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('register') }}" class="w-full inline-flex justify-center items-center py-3 bg-[#FFC700] hover:bg-black hover:text-white border-[2.5px] border-black text-black font-heading text-xs uppercase tracking-wider shadow-[2.5px_2.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                        ORDER SESSION &rarr;
                    </a>
                </div>
            </div>
        </section>

        <!-- 4. FEATURES/GEAR SECTION (SWAPPED TO SECOND POSITION) -->
        <section id="features-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 relative">
            <div class="text-center space-y-2">
                <h2 class="text-4xl sm:text-5xl font-heading uppercase tracking-wider text-[#0D0D0D] drop-shadow-[2px_2px_0px_#FFC700]">
                    ⚡ GEARS & FACILITIES ⚡
                </h2>
                <p class="text-xs sm:text-sm text-zinc-650 font-bold uppercase tracking-widest">Kualitas panggung konser langsung di dalam ruang studio latihan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1: Top-Tier Amps -->
                <div class="bg-white border-[3px] border-[#0D0D0D] p-8 shadow-[5px_5px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all duration-200 flex flex-col justify-between min-h-[300px]">
                    <div>
                        <div class="w-12 h-12 border-[2.5px] border-black bg-[#FFC700] flex items-center justify-center font-heading text-base shadow-[2px_2px_0px_0px_black] mb-6">
                            01
                        </div>
                        <h3 class="text-2xl font-heading uppercase text-black">Top-Tier Amps</h3>
                        <p class="text-xs sm:text-sm text-zinc-700 mt-4 font-bold leading-relaxed">
                            Pilihan kabinet gahar Marshall JCM900, Marshall MG100, Ampeg SVT Bass Amp, dan Roland JC-120 Jazz Chorus untuk dentuman nada presisi.
                        </p>
                    </div>
                </div>

                <!-- Card 2: Soundproof Rooms -->
                <div class="bg-white border-[3px] border-[#0D0D0D] p-8 shadow-[5px_5px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all duration-200 flex flex-col justify-between min-h-[300px]">
                    <div>
                        <div class="w-12 h-12 border-[2.5px] border-black bg-[#E14D2A] text-white flex items-center justify-center font-heading text-base shadow-[2px_2px_0px_0px_black] mb-6">
                            02
                        </div>
                        <h3 class="text-2xl font-heading uppercase text-black">Soundproof Rooms</h3>
                        <p class="text-xs sm:text-sm text-zinc-700 mt-4 font-bold leading-relaxed">
                            Insulasi akustik akustik ganda dengan busa absorber berkualitas tinggi. Mainkan musik berdistorsi tebal tanpa gangguan kebisingan eksternal.
                        </p>
                    </div>
                </div>

                <!-- Card 3: Pro Drum Kits -->
                <div class="bg-white border-[3px] border-[#0D0D0D] p-8 shadow-[5px_5px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all duration-200 flex flex-col justify-between min-h-[300px]">
                    <div>
                        <div class="w-12 h-12 border-[2.5px] border-black bg-[#FFC700] flex items-center justify-center font-heading text-base shadow-[2px_2px_0px_0px_black] mb-6">
                            03
                        </div>
                        <h3 class="text-2xl font-heading uppercase text-black">Pro Drum Kits</h3>
                        <p class="text-xs sm:text-sm text-zinc-700 mt-4 font-bold leading-relaxed">
                            Pearl Drum Export Series akustik dipasangkan dengan Cymbal Set Meinl HCS/Zildjian Planet Z tebal untuk ketukan ritme bertenaga.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="border-t-[3px] border-[#0D0D0D] py-10 bg-[#FFC700] relative z-20">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-[#0D0D0D] font-heading tracking-wider">
            &copy; 2026 BM STUDIO MUSIK. ALL RIGHTS RESERVED. UNDERGROUND SPIRIT NEVER DIES. 🤘
        </div>
    </footer>

    <!-- SCROLL-TRIGGERED 3D PARALLAX ANIMATION SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const guitar = document.getElementById('floating-guitar');
            const drums = document.getElementById('floating-drums');

            function handleScroll() {
                const scrollY = window.scrollY;
                const windowHeight = window.innerHeight;
                const documentHeight = document.documentElement.scrollHeight;
                
                // Max scroll limit
                const maxScroll = documentHeight - windowHeight;
                const scrollRatio = scrollY / (maxScroll || 1);

                const isMobile = window.innerWidth < 768;

                let guitarX, guitarY, guitarRot, guitarScale;
                let drumsX, drumsY, drumsRot, drumsScale;

                if (isMobile) {
                    // Mobile responsive: lower opacity, centered background elements
                    guitar.style.opacity = '0.08';
                    drums.style.opacity = '0.08';
                    
                    guitarX = 5; 
                    guitarY = 200 + scrollY * 0.9;
                    guitarRot = 15 + scrollY * 0.15;
                    guitarScale = 0.7;

                    drumsX = 45; 
                    drumsY = 700 + scrollY * 0.9;
                    drumsRot = -10 - scrollY * 0.12;
                    drumsScale = 0.65;
                } else {
                    guitar.style.opacity = '0.85';
                    drums.style.opacity = '0.85';

                    // Parallax interpolation based on scroll positions
                    if (scrollY < 950) {
                        // Hero scroll phase (0 to 950px)
                        const t = scrollY / 950;
                        
                        // Guitar starts in hero center-left, slides to gears right margin
                        guitarX = -5 + (65 - (-5)) * t; 
                        guitarY = 250 + (900 - 250) * t;
                        guitarRot = 20 + (-70 - 20) * t; // rotates from 20deg to -70deg
                        guitarScale = 1.15 + (0.9 - 1.15) * t;

                        // Drums start in hero center-right, slides to gears left margin
                        drumsX = 72 + (3 - 72) * t;
                        drumsY = 260 + (1100 - 260) * t;
                        drumsRot = -15 + (45 - (-15)) * t;
                        drumsScale = 1.05 + (0.8 - 1.05) * t;
                    } else {
                        // Features to Pricing scroll phase (950px onwards)
                        const t = Math.min(1, (scrollY - 950) / 800);

                        // Guitar floats from gears right back to pricing left
                        guitarX = 65 + (-85 - 65) * t;
                        guitarY = 900 + (1400 - 900) * t;
                        guitarRot = -70 + (150 - (-70)) * t;
                        guitarScale = 0.9 + (0.75 - 0.9) * t;

                        // Drums float from gears left to pricing right
                        drumsX = 3 + (75 - 3) * t;
                        drumsY = 1100 + (1300 - 1100) * t;
                        drumsRot = 45 + (-60 - 45) * t;
                        drumsScale = 0.8 + (0.7 - 0.8) * t;
                    }
                }

                // Apply dynamic transform styling
                guitar.style.transform = `translate3d(${guitarX}vw, ${guitarY}px, 0) rotate(${guitarRot}deg) scale(${guitarScale})`;
                drums.style.transform = `translate3d(${drumsX}vw, ${drumsY}px, 0) rotate(${drumsRot}deg) scale(${drumsScale})`;
            }

            // Bind listener to window scroll and resize
            window.addEventListener('scroll', handleScroll);
            window.addEventListener('resize', handleScroll);
            
            // Initial call to set positions immediately on load
            handleScroll();
        });
    </script>
</body>
</html>
