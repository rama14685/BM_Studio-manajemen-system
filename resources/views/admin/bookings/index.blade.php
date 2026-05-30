<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
                {{ __('Manajemen Booking Studio') }}
            </h2>
            <a href="{{ route('admin.bookings.create') }}" class="inline-flex items-center px-5 py-3 bg-[#FFC700] hover:bg-[#E14D2A] text-black hover:text-white border-[3px] border-black font-heading text-xs uppercase tracking-widest shadow-[3px_3px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                Tambah Booking Walk-in
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen text-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Success Alert -->
            @if(session('success'))
                <div class="bg-[#39FF14] border-[3px] border-black p-5 shadow-[4px_4px_0px_0px_black] text-black font-mono font-bold text-sm transform -rotate-0.5">
                    🤘 SUCCESS: {{ strtoupper(session('success')) }}
                </div>
            @endif

            <!-- Filters (Neo-brutalist card) -->
            <div class="bg-white border-[3px] border-black p-6 shadow-[4px_4px_0px_0px_black]">
                <h3 class="font-heading text-lg uppercase tracking-wide border-b-2 border-black pb-2 mb-4">🔍 FILTER RESERVASI</h3>
                <form method="GET" action="{{ route('admin.bookings.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-end">
                    <div>
                        <x-input-label for="status" :value="__('Status Booking')" class="text-black font-bold text-xs" />
                        <select name="status" id="status" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2px_2px_0px_0px_black]">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid / Lunas</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled / Batal</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="date" :value="__('Tanggal Latihan')" class="text-black font-bold text-xs" />
                        <input type="date" name="date" id="date" value="{{ request('date') }}"
                            class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2px_2px_0px_0px_black]">
                    </div>

                    <div>
                        <button type="submit" class="w-full inline-flex justify-center items-center py-3 bg-[#FFC700] border-[3px] border-black text-black font-heading text-xs uppercase tracking-widest shadow-[2px_2px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Booking List (Neo-brutalist card) -->
            <div class="bg-white border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_black]">
                @if($bookings->isEmpty())
                    <p class="text-center text-zinc-500 font-bold py-12">[ BELUM ADA DATA BOOKING YANG DI-INPUT ]</p>
                @else
                    <div class="overflow-x-auto border-[3px] border-black">
                        <table class="min-w-full divide-y-2 divide-black text-left text-sm">
                            <thead>
                                <tr class="bg-[#FFC700] text-black font-heading uppercase text-xs tracking-wider border-b-2 border-black">
                                    <th class="px-6 py-4 border-r-2 border-black">ID</th>
                                    <th class="px-6 py-4 border-r-2 border-black">Pelanggan</th>
                                    <th class="px-6 py-4 border-r-2 border-black">Studio</th>
                                    <th class="px-6 py-4 border-r-2 border-black">Jadwal Sewa</th>
                                    <th class="px-6 py-4 border-r-2 border-black">Total Biaya</th>
                                    <th class="px-6 py-4 border-r-2 border-black">Status</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-2 divide-black bg-[#F4F1EA] font-mono text-xs font-bold">
                                @foreach($bookings as $booking)
                                    <tr class="hover:bg-white transition-colors duration-100">
                                        <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap text-zinc-650">
                                            #{{ $booking->id }}
                                        </td>
                                        <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap font-sans">
                                            <div class="font-bold text-black text-sm">{{ $booking->user->name }}</div>
                                            <div class="text-[10px] text-zinc-500 font-bold font-mono mt-0.5">{{ $booking->user->phone ?? 'No Phone' }}</div>
                                        </td>
                                        <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap font-sans">
                                            <span class="inline-flex px-2 py-0.5 text-[10px] font-heading border-2 border-black shadow-[1px_1px_0px_0px_black] uppercase
                                                {{ $booking->studio->name === 'Studio Besar' ? 'bg-[#FFC700] text-black' : 'bg-white text-black' }}">
                                                {{ $booking->studio->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap">
                                            <div>{{ Carbon\Carbon::parse($booking->date)->format('d M Y') }}</div>
                                            <div class="text-[10px] text-zinc-500 mt-0.5">
                                                {{ Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ Carbon\Carbon::parse($booking->end_time)->format('H:i') }} WIB
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap text-[#E14D2A] text-sm">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap font-sans">
                                            <span class="px-2.5 py-0.5 text-[10px] font-heading border-2 border-black shadow-[1.5px_1.5px_0px_0px_black] uppercase
                                                @if($booking->status === 'paid') bg-[#39FF14] text-black
                                                @elseif($booking->status === 'dp') bg-[#FFC700] text-black
                                                @elseif($booking->status === 'pending') bg-white text-black
                                                @else bg-[#E14D2A] text-white
                                                @endif">
                                                @if($booking->status === 'dp')
                                                    DP: Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}
                                                @else
                                                    {{ $booking->status }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-[10px] font-heading space-x-1.5 font-bold font-sans">
                                            <div class="flex items-center justify-end gap-2">
                                                <!-- Pay Button -->
                                                @if($booking->status === 'pending' || $booking->status === 'dp')
                                                    <form action="{{ route('admin.bookings.pay', $booking->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="px-2.5 py-1 bg-[#39FF14] border-2 border-black text-black shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">LUNAS</button>
                                                    </form>
                                                @endif

                                                <!-- DP Button -->
                                                @if($booking->status === 'pending')
                                                    <button type="button" onclick="promptDP({{ $booking->id }}, {{ $booking->total_price }})" class="px-2.5 py-1 bg-[#FFC700] border-2 border-black text-black shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">DP</button>
                                                    
                                                    <form id="dp-form-{{ $booking->id }}" action="{{ route('admin.bookings.dp', $booking->id) }}" method="POST" class="hidden">
                                                        @csrf
                                                        <input type="hidden" name="dp_amount" id="dp-amount-input-{{ $booking->id }}">
                                                    </form>
                                                @endif

                                                <!-- Edit Button -->
                                                <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="px-2.5 py-1 bg-white border-2 border-black text-black shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">EDIT</a>

                                                <!-- Cancel Button -->
                                                @if($booking->status !== 'cancelled')
                                                    <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan booking ini?')">
                                                        @csrf
                                                        <button type="submit" class="px-2.5 py-1 bg-[#FFC700] border-2 border-black text-black shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">BATAL</button>
                                                    </form>
                                                @endif

                                                <!-- Delete Button -->
                                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus permanen booking ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1 bg-[#E14D2A] border-2 border-black text-white shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">HAPUS</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 font-mono font-bold text-xs">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- DP Prompt Javascript handler -->
    <script>
        function promptDP(bookingId, totalPrice) {
            let defaultAmount = Math.round(totalPrice / 2);
            let input = prompt("Masukkan nominal uang muka (DP) untuk Booking #" + bookingId + " (Maksimal Rp " + totalPrice.toLocaleString('id-ID') + "):", defaultAmount);
            
            if (input === null) return;
            
            // Clean non-numeric characters
            let amount = parseFloat(input.replace(/[^0-9]/g, ''));
            if (isNaN(amount) || amount <= 0) {
                alert("Nominal tidak valid!");
                return;
            }
            
            if (amount > totalPrice) {
                alert("Nominal DP tidak boleh melebihi total harga booking (Rp " + totalPrice.toLocaleString('id-ID') + ")!");
                return;
            }
            
            document.getElementById('dp-amount-input-' + bookingId).value = amount;
            document.getElementById('dp-form-' + bookingId).submit();
        }
    </script>
</x-app-layout>
