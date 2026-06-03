<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
            {{ __('Backstage Board') }}
        </h2>
    </x-slot>

    @php
        // Calculate loyalty points: 15 points per completed (paid) booking
        $loyaltyPoints = $userBookings->where('status', 'paid')->count() * 15;

        // Find the next upcoming active/paid/pending booking
        $nextBooking = $userBookings
            ->where('status', '!=', 'cancelled')
            ->filter(function($ub) {
                $bookingDateTime = \Carbon\Carbon::parse($ub->date . ' ' . $ub->start_time);
                return $bookingDateTime->isAfter(now());
            })
            ->sortBy('date')
            ->first();
            
        // Generate next 7 days for the interactive calendar
        $dates = [];
        for ($i = 0; $i < 7; $i++) {
            $dates[] = now()->addDays($i);
        }

        // Time slots definitions strictly display operational hours from 09:00 AM to 12:00 AM (Midnight)
        $timeSlots = [
            ['start' => '09:00:00', 'end' => '11:00:00', 'display' => '09:00 - 11:00', 'duration' => 2],
            ['start' => '11:00:00', 'end' => '13:00:00', 'display' => '11:00 - 13:00', 'duration' => 2],
            ['start' => '13:00:00', 'end' => '15:00:00', 'display' => '13:00 - 15:00', 'duration' => 2],
            ['start' => '15:00:00', 'end' => '17:00:00', 'display' => '15:00 - 17:00', 'duration' => 2],
            ['start' => '17:00:00', 'end' => '19:00:00', 'display' => '17:00 - 19:00', 'duration' => 2],
            ['start' => '19:00:00', 'end' => '21:00:00', 'display' => '19:00 - 21:00', 'duration' => 2],
            ['start' => '21:00:00', 'end' => '23:00:00', 'display' => '21:00 - 23:00', 'duration' => 2],
            ['start' => '23:00:00', 'end' => '00:00:00', 'display' => '23:00 - 00:00', 'duration' => 1],
        ];
    @endphp

    <div class="py-12 bg-[#F4F1EA] min-h-screen text-[#0D0D0D]" x-data="{ 
        selectedDate: '{{ now()->toDateString() }}',
        showCheckout: false,
        studioId: '',
        studioName: '',
        bookingDate: '',
        startTime: '',
        duration: 2,
        pricePerHour: 0,
        paymentMethod: 'qris',
        openCheckout(studioId, studioName, date, startTime, pricePerHour, duration = 2) {
            this.studioId = studioId;
            this.studioName = studioName;
            this.bookingDate = date;
            this.startTime = startTime;
            this.pricePerHour = pricePerHour;
            this.duration = duration;
            this.showCheckout = true;
        },
        getTotalPrice() {
            return this.pricePerHour * this.duration;
        },
        formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- Success/Error Alert -->
            @if(session('success'))
                <div class="bg-[#39FF14] border-[3px] border-[#0D0D0D] p-5 shadow-[4px_4px_0px_0px_#0D0D0D] text-black font-mono font-bold text-sm transform -rotate-1">
                    🤘 SUCCESS: {{ strtoupper(session('success')) }}
                </div>
            @endif

            <!-- FLUID GRID FOR SECTIONS -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- LEFT PANEL: OVERVIEW & CALENDAR (8 cols) -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- 1. MAIN DASHBOARD VIEW (Quick overview) -->
                    <div class="bg-white border-[3px] border-[#0D0D0D] p-6 shadow-[4px_4px_0px_0px_#0D0D0D] relative overflow-hidden">
                        <div class="absolute -top-3.5 -right-3.5 bg-[#FFC700] text-black text-[10px] font-heading py-2 px-6 uppercase tracking-widest border-[2.5px] border-black shadow-[2px_2px_0px_0px_black] rotate-12">
                            MEMBER CARD
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                            <!-- Left: Loyalty & Next Booking -->
                            <div class="space-y-4">
                                <h3 class="font-heading text-2xl uppercase tracking-wider text-[#E14D2A]">
                                    {{ Auth::user()->name }}
                                </h3>
                                
                                <div class="flex items-center space-x-3 bg-[#F4F1EA] border-2 border-black p-3 shadow-[2.5px_2.5px_0px_0px_black] w-fit">
                                    <span class="text-xl">🏆</span>
                                    <div>
                                        <p class="text-[10px] font-bold text-zinc-500 uppercase leading-none">LOYALTY POINTS</p>
                                        <p class="font-heading text-xl text-black mt-0.5">{{ $loyaltyPoints }} PTS</p>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <p class="text-[10px] font-bold text-zinc-500 uppercase">NEXT REHEARSAL / JADWAL BERIKUTNYA</p>
                                    @if($nextBooking)
                                        <div class="bg-[#FFC700] border-2 border-black p-3 shadow-[2px_2px_0px_0px_black] font-mono text-xs font-bold space-y-1">
                                            <p class="text-[#E14D2A] uppercase font-heading text-sm">{{ $nextBooking->studio->name }}</p>
                                            <p>{{ \Carbon\Carbon::parse($nextBooking->date)->isoFormat('dddd, D MMM Y') }}</p>
                                            <p>{{ \Carbon\Carbon::parse($nextBooking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($nextBooking->end_time)->format('H:i') }} WIB</p>
                                        </div>
                                    @else
                                        <p class="text-xs font-bold text-zinc-500 italic">[ BELUM ADA JADWAL DEPAN. SILAKAN BOOKING! ]</p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Right: Quick booking CTA button -->
                            <div class="flex flex-col justify-center items-center md:items-end">
                                <p class="text-xs font-bold text-zinc-650 text-center md:text-right mb-3 leading-relaxed">
                                    Siap membuat kebisingan? Pilih slot kosong di kalender studio untuk latihan band-mu!
                                </p>
                                <button 
                                    @click="document.getElementById('interactive-calendar').scrollIntoView({ behavior: 'smooth' })" 
                                    class="w-full sm:w-auto px-6 py-4 bg-[#FFC700] border-[3px] border-black text-black font-heading text-base uppercase tracking-wider shadow-[4px_4px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all text-center"
                                >
                                    ⚡ AMANKAN SLOT SEKARANG
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 2. INTERACTIVE CALENDAR CARD -->
                    <div id="interactive-calendar" class="bg-white border-[3px] border-[#0D0D0D] p-6 shadow-[4px_4px_0px_0px_#0D0D0D] space-y-6">
                        <div class="border-b-[3px] border-black pb-3">
                            <h3 class="font-heading text-2xl uppercase tracking-widest">
                                📅 JADWAL KETERSEDIAAN STUDIO
                            </h3>
                            <p class="text-xs text-zinc-500 font-bold mt-1">Pilih tanggal di grid di bawah untuk melihat slot waktu yang tersedia / sudah terpakai.</p>
                        </div>

                        <!-- Date Selection Grid -->
                        <div class="grid grid-cols-4 sm:grid-cols-7 gap-3 border-[3px] border-black p-3 bg-[#F4F1EA]">
                            @foreach($dates as $date)
                                <button 
                                    @click="selectedDate = '{{ $date->toDateString() }}'"
                                    :class="selectedDate === '{{ $date->toDateString() }}' ? 'bg-[#FFC700] shadow-[3px_3px_0px_0px_black]' : 'bg-white hover:bg-[#FFC700] hover:-translate-y-0.5 hover:-translate-x-0.5 shadow-[2.5px_2.5px_0px_0px_black]'"
                                    class="border-[3px] border-black p-3 text-center transition-all duration-150 flex flex-col items-center justify-center cursor-pointer group"
                                >
                                    <span class="text-[10px] uppercase font-mono font-bold text-zinc-500 group-hover:text-black">{{ $date->isoFormat('ddd') }}</span>
                                    <span class="text-lg font-heading text-black my-0.5">{{ $date->format('d') }}</span>
                                    <span class="text-[9px] font-bold text-zinc-500 uppercase tracking-wider">{{ $date->isoFormat('MMM') }}</span>
                                </button>
                            @endforeach
                        </div>

                        <!-- Time Slots Rendered Dynamically based on Selected Date -->
                        <div class="space-y-6">
                            @foreach($dates as $date)
                                <div x-show="selectedDate === '{{ $date->toDateString() }}'" x-cloak class="space-y-6">
                                    <h4 class="font-heading text-md text-[#E14D2A] uppercase tracking-wider flex items-center">
                                        ⚡ SLOT WAKTU UNTUK: {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @foreach($studios as $studio)
                                            <div class="bg-[#F4F1EA] border-[3px] border-black p-4 shadow-[3px_3px_0px_0px_black]">
                                                <div class="flex justify-between items-center border-b-2 border-black pb-2 mb-4">
                                                    <h5 class="font-heading text-base uppercase text-[#0D0D0D]">{{ $studio->name }}</h5>
                                                    <span class="text-[10px] bg-white border border-black font-mono font-bold px-2 py-0.5">
                                                        Rp {{ number_format($studio->price_per_hour, 0, ',', '.') }}/h
                                                    </span>
                                                </div>

                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    @foreach($timeSlots as $slot)
                                                        @php
                                                            // Check overlap
                                                            $isBooked = $activeBookings->contains(function($booking) use ($date, $studio, $slot) {
                                                                return $booking->studio_id == $studio->id &&
                                                                       $booking->date == $date->toDateString() &&
                                                                       $booking->start_time < $slot['end'] &&
                                                                       $booking->end_time > $slot['start'];
                                                            });
                                                        @endphp
                                                        
                                                        @if($isBooked)
                                                            <div class="bg-[#E14D2A] text-white border-2 border-black p-3 flex flex-col justify-center items-center text-center shadow-[1.5px_1.5px_0px_0px_black] opacity-80 cursor-not-allowed">
                                                                <span class="font-mono text-xs font-bold line-through text-white/80">{{ substr($slot['start'], 0, 5) }} - {{ substr($slot['end'], 0, 5) }}</span>
                                                                <span class="text-[8px] uppercase tracking-wider font-heading mt-1 text-white">BOOKED</span>
                                                            </div>
                                                        @else
                                                            <button @click.prevent="openCheckout('{{ $studio->id }}', '{{ $studio->name }}', '{{ $date->toDateString() }}', '{{ substr($slot['start'], 0, 5) }}', {{ $studio->price_per_hour }}, {{ $slot['duration'] }})" 
                                                               class="bg-white hover:bg-[#FFC700] text-black border-2 border-black p-3 flex flex-col justify-center items-center text-center shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all cursor-pointer group">
                                                                <span class="font-mono text-xs font-bold text-black">{{ substr($slot['start'], 0, 5) }} - {{ substr($slot['end'], 0, 5) }}</span>
                                                                <span class="text-[8px] uppercase tracking-wider font-heading mt-1 text-green-600 group-hover:text-black font-extrabold">AVAILABLE</span>
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- RIGHT PANEL: CHAT WITH ADMIN (4 cols) -->
                <div class="lg:col-span-4 space-y-8">
                    
                    <!-- "CHAT ADMIN" INTERFACE -->
                    <div class="bg-white border-[3px] border-[#0D0D0D] shadow-[4px_4px_0px_0px_#0D0D0D] flex flex-col h-[550px]">
                        <!-- Chat Header -->
                        <div class="p-4 bg-[#FFC700] border-b-[3px] border-black flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 border-2 border-black bg-white flex items-center justify-center font-heading text-sm uppercase shadow-[1.5px_1.5px_0px_0px_black]">
                                    AD
                                </div>
                                <div>
                                    <h3 class="font-heading text-sm uppercase tracking-wide">ADMIN SUPPORT</h3>
                                    <span class="text-[10px] text-zinc-950 font-bold flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-green-500 mr-1.5 animate-pulse border border-black"></span> Live Obrolan
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Messages Container -->
                        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto bg-[#F4F1EA] space-y-4">
                            @if($messages->isEmpty())
                                <div id="no-messages-prompt" class="text-center text-zinc-500 font-bold py-12 text-xs space-y-2">
                                    <p class="font-heading uppercase text-sm">[ BELUM ADA PESAN ]</p>
                                    <p>Tulis pesan di bawah untuk memulai obrolan langsung dengan admin studio.</p>
                                </div>
                            @else
                                @foreach($messages as $msg)
                                    @include('chat.partials.message_bubble', ['msg' => $msg])
                                @endforeach
                            @endif
                        </div>

                        <!-- Chat Input Form -->
                        <div class="p-3 bg-white border-t-[3px] border-black">
                            <form id="chat-form" class="flex space-x-2">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $admin->id }}">
                                
                                <input type="text" id="chat-message-input" name="message" placeholder="Tulis pesan..." autocomplete="off" required
                                    class="flex-1 border-[2.5px] border-[#0D0D0D] bg-white text-black text-xs font-bold focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2px_2px_0px_0px_black] px-3 py-2">
                                
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#FFC700] border-[2.5px] border-black text-black font-heading text-xs uppercase tracking-wider shadow-[2px_2px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 active:shadow-none transition-all">
                                    SEND
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. RIWAYAT GIGS / USER BOOKINGS (Bulletin tape records) -->
            <div id="my-bookings" class="bg-white border-[3px] border-[#0D0D0D] p-6 shadow-[4px_4px_0px_0px_#0D0D0D] scroll-mt-6">
                <h3 class="font-heading text-2xl uppercase tracking-widest border-b-[3px] border-black pb-3 mb-6">
                    ⚡ RIWAYAT GIGS / BOOKING ANDA
                </h3>

                @if($userBookings->isEmpty())
                    <p class="text-center text-zinc-500 font-bold py-8">[ BELUM ADA RIWAYAT SEWA - AYO MULAI LATIHAN PERTAMAMU ]</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($userBookings as $ub)
                            <!-- Clippings taped feel -->
                            <div class="bg-[#F4F1EA] border-[3px] border-black p-5 relative shadow-[3px_3px_0px_0px_black] hover:border-[#E14D2A] transition-colors">
                                <!-- Tape decor -->
                                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#FFC700] text-black text-[9px] font-heading py-1 px-4 uppercase tracking-widest border-2 border-black shadow-[1.5px_1.5px_0px_0px_black]">
                                    GIG TICKET
                                </div>
                                
                                <div class="text-xs font-bold space-y-2 mt-2 font-mono">
                                    <div class="flex justify-between items-center border-b border-black/10 pb-1.5">
                                        <span class="text-[#E14D2A] font-heading text-xs">GIG #{{ $ub->id }}</span>
                                        <span class="text-[9px] text-zinc-500">{{ $ub->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="text-sm font-heading text-[#0D0D0D] flex justify-between">
                                        <span>STUDIO:</span>
                                        <span class="text-[#E14D2A]">{{ strtoupper($ub->studio->name) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>TANGGAL:</span>
                                        <span>{{ \Carbon\Carbon::parse($ub->date)->isoFormat('dddd, D MMM Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>WAKTU:</span>
                                        <span>{{ \Carbon\Carbon::parse($ub->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($ub->end_time)->format('H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between border-t border-black/10 pt-1.5 text-sm font-bold">
                                        <span>TOTAL BIAYA:</span>
                                        <span class="text-[#E14D2A]">Rp {{ number_format($ub->total_price, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-1 font-sans">
                                        <span>STATUS:</span>
                                        <span class="px-2.5 py-0.5 text-[9px] font-heading border-2 border-black shadow-[1.5px_1.5px_0px_0px_black] uppercase
                                            @if($ub->status === 'paid') bg-[#39FF14] text-black
                                            @elseif($ub->status === 'dp') bg-[#FFC700] text-black
                                            @elseif($ub->status === 'pending') bg-white text-black
                                            @else bg-[#E14D2A] text-white
                                            @endif">
                                            @if($ub->status === 'dp')
                                                DP: Rp {{ number_format($ub->dp_amount, 0, ',', '.') }}
                                            @else
                                                {{ $ub->status }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- BOOKING CHECKOUT & PAYMENT MODAL -->
    <div 
        x-show="showCheckout" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
        @keydown.escape.window="showCheckout = false"
    >
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/70 transition-opacity" @click="showCheckout = false"></div>

        <!-- Modal Content Container -->
        <div class="relative bg-white border-[4px] border-[#0D0D0D] p-6 max-w-lg w-full shadow-[8px_8px_0px_0px_#0D0D0D] z-55 overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="bg-[#FFC700] border-[3px] border-[#0D0D0D] p-4 mb-5 shadow-[3px_3px_0px_0px_rgba(13,13,13,1)]">
                <h3 class="font-heading text-xl uppercase tracking-widest text-[#0D0D0D]">
                    ⚡ CHECKOUT & CONFIRM ⚡
                </h3>
            </div>

            <!-- Booking Summary -->
            <div class="border-[3px] border-black p-4 bg-[#F4F1EA] space-y-2.5 font-mono text-xs font-bold mb-5 shadow-[2px_2px_0px_0px_#0D0D0D]">
                <div class="flex justify-between border-b border-black/10 pb-1.5 text-sm font-heading">
                    <span class="text-black">STUDIO:</span>
                    <span class="text-[#E14D2A]" x-text="studioName.toUpperCase()"></span>
                </div>
                <div class="flex justify-between">
                    <span>TANGGAL:</span>
                    <span x-text="bookingDate"></span>
                </div>
                <div class="flex justify-between">
                    <span>JAM LATIHAN:</span>
                    <span x-text="startTime + ' WIB'"></span>
                </div>
                <div class="flex justify-between">
                    <span>DURASI SEWA:</span>
                    <span x-text="duration + ' JAM'"></span>
                </div>
                <div class="flex justify-between border-t border-black/10 pt-1.5 text-sm font-bold text-black">
                    <span>TOTAL HARGA:</span>
                    <span class="text-[#E14D2A]" x-text="formatRupiah(getTotalPrice())"></span>
                </div>
            </div>

            <!-- Payment Form -->
            <form method="POST" action="{{ route('bookings.store') }}">
                @csrf
                <input type="hidden" name="studio_id" :value="studioId">
                <input type="hidden" name="date" :value="bookingDate">
                <input type="hidden" name="start_time" :value="startTime">
                <input type="hidden" name="duration" :value="duration">

                <!-- Payment Methods -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-black uppercase tracking-wider">Pilih Metode Pembayaran</label>
                    <div class="grid grid-cols-3 gap-3">
                        <!-- QRIS -->
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="sr-only">
                            <div :class="paymentMethod === 'qris' ? 'bg-[#FFC700] border-[#0D0D0D]' : 'bg-[#F4F1EA] border-zinc-400 opacity-60'" class="border-[3px] p-3 text-center transition-all duration-150 shadow-[2px_2px_0px_0px_#0D0D0D] font-heading text-[10px] uppercase text-black hover:opacity-100 select-none">
                                📱 QRIS
                            </div>
                        </label>
                        <!-- E-Wallet -->
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="ewallet" x-model="paymentMethod" class="sr-only">
                            <div :class="paymentMethod === 'ewallet' ? 'bg-[#FFC700] border-[#0D0D0D]' : 'bg-[#F4F1EA] border-zinc-400 opacity-60'" class="border-[3px] p-3 text-center transition-all duration-150 shadow-[2px_2px_0px_0px_#0D0D0D] font-heading text-[10px] uppercase text-black hover:opacity-100 select-none">
                                💳 E-Wallet
                            </div>
                        </label>
                        <!-- Bank Transfer -->
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="bank" x-model="paymentMethod" class="sr-only">
                            <div :class="paymentMethod === 'bank' ? 'bg-[#FFC700] border-[#0D0D0D]' : 'bg-[#F4F1EA] border-zinc-400 opacity-60'" class="border-[3px] p-3 text-center transition-all duration-150 shadow-[2px_2px_0px_0px_#0D0D0D] font-heading text-[10px] uppercase text-black hover:opacity-100 select-none">
                                🏦 Bank
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-4 bg-[#FFC700] border-[3px] border-[#0D0D0D] text-black font-heading text-sm uppercase tracking-wider shadow-[4px_4px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all text-center font-extrabold cursor-pointer">
                        PAY & CONFIRM
                    </button>
                    <button type="button" @click="showCheckout = false" class="w-full py-2.5 bg-white border-[3px] border-[#0D0D0D] text-black font-heading text-xs uppercase tracking-wider shadow-[2px_2px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all text-center cursor-pointer">
                        BATALKAN
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Live Chat AJAX Handling Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.getElementById('chat-messages');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-message-input');
            const noMessagesPrompt = document.getElementById('no-messages-prompt');
            const otherUserId = "{{ $admin ? $admin->id : '' }}";

            if (!otherUserId) return;

            // Scroll chat to bottom
            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            scrollToBottom();

            // Handle Message Submission via AJAX
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const msgText = chatInput.value.trim();
                if (!msgText) return;

                const formData = new FormData(chatForm);
                chatInput.value = '';

                fetch("{{ route('chat.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (noMessagesPrompt) {
                            noMessagesPrompt.remove();
                        }
                        chatMessages.insertAdjacentHTML('beforeend', data.html);
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    chatInput.value = msgText;
                });
            });

            // Polling for incoming messages every 3 seconds
            setInterval(function() {
                fetch(`/chat/fetch/${otherUserId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            if (noMessagesPrompt && data.html.trim() !== '') {
                                noMessagesPrompt.remove();
                            }
                            const isAtBottom = chatMessages.scrollHeight - chatMessages.clientHeight <= chatMessages.scrollTop + 100;
                            chatMessages.innerHTML = data.html;
                            if (isAtBottom) {
                                scrollToBottom();
                            }
                        }
                    })
                    .catch(error => console.error('Error polling messages:', error));
            }, 3000);
        });
    </script>
</x-app-layout>
