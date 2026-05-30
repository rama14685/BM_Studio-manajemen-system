<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase">
            {{ __('BACKSTAGE ADMIN CONSOLE') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12 text-[#0D0D0D]">
            
            <!-- Warning Sticker (Low Stock) -->
            @if($lowStockDrinks->isNotEmpty())
                <div class="bg-[#FFC700] border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_rgba(13,13,13,1)] transform -rotate-1 relative overflow-hidden">
                    <h4 class="font-heading text-lg uppercase tracking-wider flex items-center">
                        ⚠️ WARNING: STOCK RUNNING OUT!
                    </h4>
                    <ul class="mt-2 list-disc list-inside text-xs font-bold font-mono">
                        @foreach($lowStockDrinks as $item)
                            <li>{{ strtoupper($item->name) }} (RESTOCK NOW! SISA STOK: {{ $item->stock_qty }})</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- 1. KEY FINANCIAL METRICS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Total Income -->
                <div class="bg-white border-[3px] border-black p-6 shadow-[6px_6px_0px_0px_rgba(57,255,20,1)] hover:-translate-y-1 transition-all">
                    <span class="text-xs font-mono font-bold text-[#E14D2A] uppercase tracking-widest">[ INFLOW_REVENUE ]</span>
                    <h3 class="text-lg font-heading uppercase mt-1">Total Pendapatan</h3>
                    <div class="font-heading text-4xl text-[#0D0D0D] mt-4 tracking-wider">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Total Expense -->
                <div class="bg-white border-[3px] border-black p-6 shadow-[6px_6px_0px_0px_rgba(225,77,42,1)] hover:-translate-y-1 transition-all">
                    <span class="text-xs font-mono font-bold text-[#E14D2A] uppercase tracking-widest">[ OUTFLOW_EXPENSES ]</span>
                    <h3 class="text-lg font-heading uppercase mt-1">Total Pengeluaran</h3>
                    <div class="font-heading text-4xl text-[#0D0D0D] mt-4 tracking-wider">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Net Balance -->
                <div class="bg-white border-[3px] border-black p-6 shadow-[6px_6px_0px_0px_rgba(255,199,0,1)] hover:-translate-y-1 transition-all">
                    <span class="text-xs font-mono font-bold text-zinc-500 uppercase tracking-widest">[ NET_BALANCE_LOG ]</span>
                    <h3 class="text-lg font-heading uppercase mt-1">Saldo Bersih</h3>
                    <div class="font-heading text-4xl text-[#E14D2A] mt-4 tracking-wider">
                        Rp {{ number_format($netBalance, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- 2. QUICK PANEL & REVENUE DISTRIBUTION -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Revenue Distribution Stencil -->
                <div class="lg:col-span-8 bg-white border-[3px] border-black p-6 shadow-[6px_6px_0px_0px_rgba(13,13,13,1)] space-y-6">
                    <h3 class="font-heading text-2xl uppercase tracking-wider border-b-2 border-black pb-2">DISTRIBUSI PENDAPATAN</h3>
                    
                    <div class="space-y-6 font-mono text-sm font-bold">
                        <!-- Booking Studio -->
                        <div>
                            <div class="flex justify-between mb-2">
                                <span>[01] SEWA STUDIO</span>
                                <span class="text-[#E14D2A]">Rp {{ number_format($bookingIncome, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-[#F4F1EA] border-2 border-black h-5 overflow-hidden">
                                @php $bookingPct = $totalIncome > 0 ? ($bookingIncome / $totalIncome) * 100 : 0; @endphp
                                <div class="bg-[#E14D2A] h-full border-r-2 border-black" style="width: {{ $bookingPct }}%"></div>
                            </div>
                        </div>

                        <!-- Drinks POS -->
                        <div>
                            <div class="flex justify-between mb-2">
                                <span>[02] KASIR MINUMAN</span>
                                <span class="text-zinc-800">Rp {{ number_format($drinksIncome, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-[#F4F1EA] border-2 border-black h-5 overflow-hidden">
                                @php $drinksPct = $totalIncome > 0 ? ($drinksIncome / $totalIncome) * 100 : 0; @endphp
                                <div class="bg-[#FFC700] h-full border-r-2 border-black" style="width: {{ $drinksPct }}%"></div>
                            </div>
                        </div>

                        <!-- Other Incomes -->
                        <div>
                            <div class="flex justify-between mb-2">
                                <span>[03] LAIN-LAIN</span>
                                <span class="text-zinc-650">Rp {{ number_format($otherIncome, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-[#F4F1EA] border-2 border-black h-5 overflow-hidden">
                                @php $otherPct = $totalIncome > 0 ? ($otherIncome / $totalIncome) * 100 : 0; @endphp
                                <div class="bg-zinc-400 h-full border-r-2 border-black" style="width: {{ $otherPct }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Status Console -->
                <div class="lg:col-span-4 bg-white border-[3px] border-black p-6 shadow-[6px_6px_0px_0px_rgba(13,13,13,1)] flex flex-col justify-between">
                    <h3 class="font-heading text-xl uppercase tracking-wider border-b-2 border-black pb-2">BOOKING CONSOLE</h3>
                    
                    <div class="grid grid-cols-2 gap-4 my-6">
                        <div class="bg-[#F4F1EA] border-2 border-black p-4 text-center">
                            <span class="font-heading text-4xl text-[#E14D2A] block">{{ $pendingBookingsCount }}</span>
                            <span class="text-[10px] font-mono font-bold text-zinc-500 uppercase">PENDING</span>
                        </div>
                        <div class="bg-[#F4F1EA] border-2 border-black p-4 text-center">
                            <span class="font-heading text-4xl text-black block">{{ $activeBookingsCount }}</span>
                            <span class="text-[10px] font-mono font-bold text-zinc-500 uppercase">LUNAS</span>
                        </div>
                    </div>

                    <a href="{{ route('admin.pos.index') }}" class="w-full inline-flex justify-center items-center py-3.5 bg-[#FFC700] border-[3px] border-black text-black font-heading text-md uppercase tracking-wider shadow-[4px_4px_0px_0px_rgba(13,13,13,1)] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">
                        OPEN POS / KASIR
                    </a>
                </div>
            </div>

            <!-- 3. STAGE SETLIST: ACTIVE BOOKINGS -->
            <div class="bg-white border-[3px] border-black p-6 shadow-[6px_6px_0px_0px_rgba(13,13,13,1)]">
                <h3 class="font-heading text-2xl uppercase tracking-widest border-b-[3px] border-black pb-3 mb-6">
                    🎵 TODAY'S STAGE SETLIST (JADWAL BOOKING)
                </h3>

                @php
                    $setlistBookings = \App\Models\Booking::with(['user', 'studio'])
                        ->where('date', '>=', now()->toDateString())
                        ->whereIn('status', ['pending', 'paid'])
                        ->orderBy('date')
                        ->orderBy('start_time')
                        ->limit(10)
                        ->get();
                @endphp

                @if($setlistBookings->isEmpty())
                    <p class="text-center text-zinc-500 font-mono font-bold py-8">[ STAGE IS CLEAR / BELUM ADA JADWAL LATIHAN ]</p>
                @else
                    <div class="space-y-4">
                        @foreach($setlistBookings as $idx => $booking)
                            <div class="flex flex-col md:flex-row items-start md:items-center justify-between p-4 bg-[#F4F1EA] border-[3px] border-black hover:border-[#E14D2A] transition-all duration-150 font-mono text-sm font-bold shadow-[2px_2px_0px_0px_rgba(13,13,13,1)]">
                                
                                <div class="flex items-center space-x-4">
                                    <!-- Setlist Number -->
                                    <span class="font-heading text-2xl text-[#E14D2A] w-8">#{{ $idx + 1 }}</span>
                                    <div>
                                        <div class="text-[#0D0D0D] text-base font-heading uppercase tracking-wide">
                                            {{ $booking->user->name }} &mdash; 
                                            <span class="text-zinc-650">{{ $booking->studio->name }}</span>
                                        </div>
                                        <div class="text-xs text-zinc-500 mt-0.5 font-bold">
                                            Tanggal: {{ \Carbon\Carbon::parse($booking->date)->format('d/m/Y') }} | 
                                            Slot: <strong class="text-black">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4 mt-4 md:mt-0 w-full md:w-auto justify-between md:justify-end">
                                    <div class="text-right mr-4">
                                        <span class="text-xs text-zinc-500 block">TOTAL TAGIHAN</span>
                                        <span class="text-[#E14D2A] font-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <!-- Status Badge -->
                                        <span class="px-2.5 py-1 text-xs border-2 border-black rounded-none uppercase font-heading
                                            {{ $booking->status === 'paid' ? 'bg-[#39FF14] text-black' : 'bg-[#FFC700] text-black' }}">
                                            {{ $booking->status }}
                                        </span>

                                        <!-- Quick buttons -->
                                        @if($booking->status === 'pending')
                                            <form action="{{ route('admin.bookings.pay', $booking->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 bg-[#39FF14] border-2 border-black text-black font-heading text-xs uppercase tracking-wider hover:bg-green-400 shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                                                    PAY
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan booking ini?')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-white border-2 border-black text-black font-heading text-xs uppercase tracking-wider hover:bg-[#E14D2A] hover:text-white shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                                                CANCEL
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- 4. RECENT FINANCIAL RECORDS LOGS -->
            <div class="bg-white border-[3px] border-black p-6 shadow-[6px_6px_0px_0px_rgba(13,13,13,1)]">
                <h3 class="font-heading text-2xl uppercase tracking-widest border-b-[3px] border-black pb-3 mb-6">
                    📋 CASH BOOK RECORD LOGS (TRANSAKSI TERBARU)
                </h3>

                @if($recentTransactions->isEmpty())
                    <p class="text-center text-zinc-500 font-mono font-bold py-8">[ NO FINANCIAL LOGS RECORDED ]</p>
                @else
                    <div class="space-y-3 font-mono text-xs font-bold">
                        @foreach($recentTransactions as $trans)
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-3 bg-[#F4F1EA] border-2 border-black rounded shadow-[1px_1px_0px_0px_rgba(13,13,13,1)]">
                                <div class="flex items-center space-x-3">
                                    <span class="text-zinc-500">[{{ \Carbon\Carbon::parse($trans->date)->format('d/m/y') }}]</span>
                                    <span class="px-2 py-0.5 rounded border border-black uppercase 
                                        {{ $trans->type === 'income' ? 'bg-[#39FF14] text-black' : 'bg-[#E14D2A] text-white' }}">
                                        {{ $trans->type === 'income' ? 'IN' : 'OUT' }}
                                    </span>
                                    <span class="text-zinc-500">#{{ strtoupper($trans->category) }}</span>
                                    <span class="text-black">{{ $trans->description }}</span>
                                </div>
                                <div class="mt-2 sm:mt-0 font-heading text-sm {{ $trans->type === 'income' ? 'text-green-600' : 'text-[#E14D2A]' }}">
                                    {{ $trans->type === 'income' ? '+' : '-' }} Rp {{ number_format($trans->amount, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
