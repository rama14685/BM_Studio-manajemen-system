<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BM Studio - Rental Studio Band & Musik</title>
    
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
<body class="bg-[#F4F1EA] text-[#0D0D0D] min-h-screen antialiased flex flex-col justify-between selection:bg-[#FFC700] selection:text-[#0D0D0D]">

    <!-- Header Navigation -->
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

    <main class="flex-grow space-y-24 pb-24">

        <!-- 1. HERO SECTION -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 text-center space-y-8">
            <div class="inline-flex items-center space-x-2 bg-[#FFC700] border-[3px] border-[#0D0D0D] px-6 py-2 font-heading text-sm uppercase text-[#0D0D0D] tracking-widest shadow-[3px_3px_0px_0px_rgba(13,13,13,1)]">
                <span>⚡ ROCK AND ROLL MUSIC HUB</span>
            </div>
            
            <h1 class="text-5xl sm:text-7xl font-heading uppercase tracking-tight text-[#0D0D0D] max-w-4xl mx-auto leading-none drop-shadow-[3px_3px_0px_rgba(255,199,0,1)]">
                TEMPATNYA ANAK MUDA <span class="text-[#E14D2A]">BEREKSPRESI</span>
            </h1>
            
            <p class="text-md sm:text-lg text-[#0D0D0D] max-w-2xl mx-auto font-bold leading-relaxed">
                Mainkan musikmu dengan dentuman maksimal. Gear konser premium, studio ber-AC dingin, dan proses booking kasir 100% transparan.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-4.5 bg-[#FFC700] border-[3px] border-[#0D0D0D] text-[#0D0D0D] font-heading text-md uppercase tracking-wider shadow-[4px_4px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all text-center">
                        BUKA DASHBOARD ANDA
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4.5 bg-[#E14D2A] border-[3px] border-[#0D0D0D] text-white font-heading text-md uppercase tracking-wider shadow-[4px_4px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all text-center">
                        BOOK NOW / DAFTAR
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4.5 bg-white border-[3px] border-[#0D0D0D] text-[#0D0D0D] font-heading text-md uppercase tracking-wider shadow-[4px_4px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all text-center">
                        MASUK MEMBER
                    </a>
                @endauth
            </div>
        </section>

        <!-- 2. IMAGE CAROUSEL SECTION -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative w-full h-[350px] sm:h-[500px] border-[3px] border-[#0D0D0D] shadow-[5px_5px_0px_0px_rgba(13,13,13,1)] bg-white overflow-hidden group">
                
                <!-- Slides wrapper -->
                <div id="carousel-wrapper" class="w-full h-full relative">
                    <!-- Slide 1 -->
                    <div class="carousel-slide absolute inset-0 opacity-100 transition-opacity duration-700 ease-in-out">
                        <img src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&w=1200&h=600&q=80" alt="Recording Studio" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-transparent to-transparent flex items-end p-8 sm:p-12">
                            <div>
                                <span class="px-3 py-1 bg-[#E14D2A] border-2 border-black text-white font-bold text-xs uppercase rounded-none tracking-wider">Studio Besar</span>
                                <h3 class="text-xl sm:text-3xl font-heading text-white mt-2 uppercase">Ruang Latihan Premium & Recording</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-700 ease-in-out">
                        <img src="https://images.unsplash.com/photo-1510915361894-db8b60106cb1?auto=format&fit=crop&w=1200&h=600&q=80" alt="Guitars" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-transparent to-transparent flex items-end p-8 sm:p-12">
                            <div>
                                <span class="px-3 py-1 bg-[#FFC700] border-2 border-black text-black font-bold text-xs uppercase rounded-none tracking-wider">Premium Instruments</span>
                                <h3 class="text-xl sm:text-3xl font-heading text-white mt-2 uppercase">Gitar & Bass Kelas Panggung Konser</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-700 ease-in-out">
                        <img src="https://images.unsplash.com/photo-1519890266731-259800ee451b?auto=format&fit=crop&w=1200&h=600&q=80" alt="Drum Set" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-transparent to-transparent flex items-end p-8 sm:p-12">
                            <div>
                                <span class="px-3 py-1 bg-[#E14D2A] border-2 border-black text-white font-bold text-xs uppercase rounded-none tracking-wider">High Quality Beat</span>
                                <h3 class="text-xl sm:text-3xl font-heading text-white mt-2 uppercase">Drum Akustik Set Tebal & Menggelegar</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 4 -->
                    <div class="carousel-slide absolute inset-0 opacity-0 transition-opacity duration-700 ease-in-out">
                        <img src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?auto=format&fit=crop&w=1200&h=600&q=80" alt="Live Concert" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0D0D0D] via-transparent to-transparent flex items-end p-8 sm:p-12">
                            <div>
                                <span class="px-3 py-1 bg-[#FFC700] border-2 border-black text-black font-bold text-xs uppercase rounded-none tracking-wider">Live Vibe</span>
                                <h3 class="text-xl sm:text-3xl font-heading text-white mt-2 uppercase">Suasana Panggung Hidup Di Setiap Latihan</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation arrows -->
                <button id="carousel-prev" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-[#FFC700] border-[3px] border-black rounded-none flex items-center justify-center text-black hover:bg-[#E14D2A] hover:text-white transition shadow-[3px_3px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 opacity-0 group-hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button id="carousel-next" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-[#FFC700] border-[3px] border-black rounded-none flex items-center justify-center text-black hover:bg-[#E14D2A] hover:text-white transition shadow-[3px_3px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 opacity-0 group-hover:opacity-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>

                <!-- Indicator Dots -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2.5 z-20">
                    <button class="carousel-dot w-4.5 h-4.5 border-2 border-black bg-[#E14D2A] transition"></button>
                    <button class="carousel-dot w-4.5 h-4.5 border-2 border-black bg-white hover:bg-[#FFC700] transition"></button>
                    <button class="carousel-dot w-4.5 h-4.5 border-2 border-black bg-white hover:bg-[#FFC700] transition"></button>
                    <button class="carousel-dot w-4.5 h-4.5 border-2 border-black bg-white hover:bg-[#FFC700] transition"></button>
                </div>

            </div>
        </section>

        <!-- 3. FEATURE ADVANTAGES GRID -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center">
                <h2 class="text-3xl font-heading uppercase tracking-widest text-[#0D0D0D]">Kenapa Latihan di BM Studio?</h2>
                <p class="text-sm text-zinc-600 font-bold mt-2">Dukungan penuh fasilitas penunjang band Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white border-[3px] border-[#0D0D0D] rounded-none p-8 shadow-[4px_4px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition duration-300 relative group">
                    <div class="absolute -top-5 left-8 px-4 py-1.5 bg-[#FFC700] border-[2px] border-black text-[#0D0D0D] font-heading shadow-[2px_2px_0px_0px_rgba(13,13,13,1)]">01</div>
                    <h3 class="text-xl font-heading uppercase text-[#0D0D0D] mt-2">Peralatan Standar Konser</h3>
                    <p class="text-sm text-zinc-700 mt-3 font-medium leading-relaxed">
                        Kami menyediakan Cabinet Marshall JCM900, Marshall MG, Ampeg Bass Amp, Pearl Drum Export, serta mikrofon Shure SM58 untuk kualitas vocal gahar.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white border-[3px] border-[#0D0D0D] rounded-none p-8 shadow-[4px_4px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition duration-300 relative group">
                    <div class="absolute -top-5 left-8 px-4 py-1.5 bg-[#E14D2A] border-[2px] border-black text-white font-heading shadow-[2px_2px_0px_0px_rgba(13,13,13,1)]">02</div>
                    <h3 class="text-xl font-heading uppercase text-[#0D0D0D] mt-2">Booking Real-Time</h3>
                    <p class="text-sm text-zinc-700 mt-3 font-medium leading-relaxed">
                        Tidak perlu lagi telepon berulang kali. Cukup login, pilih tipe studio (Kecil/Besar), tentukan jam serta durasi sewa, total harga otomatis keluar!
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white border-[3px] border-[#0D0D0D] rounded-none p-8 shadow-[4px_4px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition duration-300 relative group">
                    <div class="absolute -top-5 left-8 px-4 py-1.5 bg-[#FFC700] border-[2px] border-black text-[#0D0D0D] font-heading shadow-[2px_2px_0px_0px_rgba(13,13,13,1)]">03</div>
                    <h3 class="text-xl font-heading uppercase text-[#0D0D0D] mt-2">Kantin & Lounge Band</h3>
                    <p class="text-sm text-zinc-700 mt-3 font-medium leading-relaxed">
                        Nikmati area tunggu band yang santai. Tersedia kulkas kasir berisi aneka minuman dingin untuk menyegarkan tenggorokan Anda selepas bernyanyi.
                    </p>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="border-t-[3px] border-[#0D0D0D] py-8 bg-[#FFC700]">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-[#0D0D0D] font-heading tracking-wider">
            &copy; 2026 BM STUDIO MUSIK. ALL RIGHTS RESERVED. UNDERGROUND SPIRIT NEVER DIES.
        </div>
    </footer>

    <!-- Carousel Javascript Slider Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-dot');
            const btnPrev = document.getElementById('carousel-prev');
            const btnNext = document.getElementById('carousel-next');
            
            let currentIndex = 0;
            let slideInterval = null;
            const AUTO_TIME = 3000; // 3 seconds

            function showSlide(index) {
                // Remove active classes
                slides[currentIndex].classList.remove('opacity-100');
                slides[currentIndex].classList.add('opacity-0');
                dots[currentIndex].classList.remove('bg-[#E14D2A]');
                dots[currentIndex].classList.add('bg-white');

                // Update index
                currentIndex = (index + slides.length) % slides.length;

                // Show new slide
                slides[currentIndex].classList.remove('opacity-0');
                slides[currentIndex].classList.add('opacity-100');
                dots[currentIndex].classList.remove('bg-white');
                dots[currentIndex].classList.add('bg-[#E14D2A]');
            }

            function nextSlide() {
                showSlide(currentIndex + 1);
            }

            function prevSlide() {
                showSlide(currentIndex - 1);
            }

            // Start auto slide timer
            function startTimer() {
                if (slideInterval) clearInterval(slideInterval);
                slideInterval = setInterval(nextSlide, AUTO_TIME);
            }

            // Reset timer on manual action
            function handleManualAction(actionFn) {
                actionFn();
                startTimer();
            }

            // Bind Arrow buttons click
            btnPrev.addEventListener('click', () => handleManualAction(prevSlide));
            btnNext.addEventListener('click', () => handleManualAction(nextSlide));

            // Bind Dot buttons click
            dots.forEach((dot, idx) => {
                dot.addEventListener('click', () => handleManualAction(() => showSlide(idx)));
            });

            // Start on page load
            startTimer();
        });
    </script>
</body>
</html>
