<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
            {{ __('Tambah Booking Walk-in') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen text-[#0D0D0D]">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-[3px] border-[#0D0D0D] shadow-[6px_6px_0px_0px_black] p-6">
                <div class="text-[#0D0D0D]">
                    
                    <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center text-sm text-zinc-600 hover:text-[#E14D2A] mb-6 font-bold">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Daftar Booking
                    </a>

                    <form method="POST" action="{{ route('admin.bookings.store') }}" class="space-y-6">
                        @csrf

                        <!-- Pelanggan Selection -->
                        <div>
                            <x-input-label for="user_id" :value="__('Pilih Akun Pelanggan')" class="text-black font-bold text-sm" />
                            <select id="user_id" name="user_id" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]" required>
                                <option value="" disabled selected>Pilih pelanggan...</option>
                                @foreach($users as $cust)
                                    <option value="{{ $cust->id }}" {{ old('user_id') == $cust->id ? 'selected' : '' }}>
                                        {{ $cust->name }} ({{ $cust->email }} - {{ $cust->phone ?? 'Tanpa No HP' }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Studio Selection -->
                        <div>
                            <x-input-label for="studio_id" :value="__('Pilih Studio')" class="text-black font-bold text-sm" />
                            <select id="studio_id" name="studio_id" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]" required>
                                <option value="" disabled selected>Pilih studio...</option>
                                @foreach($studios as $studio)
                                    <option value="{{ $studio->id }}" data-price="{{ $studio->price_per_hour }}" {{ old('studio_id') == $studio->id ? 'selected' : '' }}>
                                        {{ $studio->name }} (Rp. {{ number_format($studio->price_per_hour, 0, ',', '.') }}/jam)
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('studio_id')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Date Selection -->
                        <div>
                            <x-input-label for="date" :value="__('Tanggal Latihan')" class="text-black font-bold text-sm" />
                            <input id="date" type="date" name="date" value="{{ old('date', now()->toDateString()) }}" required
                                class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]">
                            <x-input-error :messages="$errors->get('date')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Start Time Selection -->
                        <div>
                            <x-input-label for="start_time" :value="__('Jam Mulai (Contoh: 14:00)')" class="text-black font-bold text-sm" />
                            <input id="start_time" type="time" name="start_time" value="{{ old('start_time') }}" required
                                class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]">
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Duration Selection -->
                        <div>
                            <x-input-label for="duration" :value="__('Durasi Sewa')" class="text-black font-bold text-sm" />
                            <select id="duration" name="duration" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]" required>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('duration') == $i ? 'selected' : '' }}>{{ $i }} Jam</option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('duration')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Status Selection -->
                        <div>
                            <x-input-label for="status" :value="__('Status Pembayaran')" class="text-black font-bold text-sm" />
                            <select id="status" name="status" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]" required>
                                <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Estimasi display -->
                        <div class="bg-[#FFC700] border-[3px] border-[#0D0D0D] p-6 shadow-[3px_3px_0px_0px_black] flex justify-between items-center">
                            <div>
                                <h4 class="font-heading text-lg text-black uppercase">Total Harga Sewa</h4>
                                <p class="text-xs text-black font-bold">Dihitung otomatis berdasarkan durasi.</p>
                            </div>
                            <div class="text-right">
                                <span id="total_price_display" class="text-3xl font-heading text-[#0D0D0D] drop-shadow-[1px_1px_0px_white]">Rp 0</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-[#E14D2A] border-[3px] border-black text-white font-heading text-md uppercase tracking-wider shadow-[4px_4px_0px_0px_black] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">
                                {{ __('Simpan Booking Walk-in') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Client-Side Auto-Calculations -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const studioSelect = document.getElementById('studio_id');
            const durationSelect = document.getElementById('duration');
            const totalDisplay = document.getElementById('total_price_display');

            function calculateTotal() {
                const selectedOption = studioSelect.options[studioSelect.selectedIndex];
                if (!selectedOption || selectedOption.value === "") {
                    totalDisplay.textContent = "Rp 0";
                    return;
                }

                const pricePerHour = parseFloat(selectedOption.getAttribute('data-price'));
                const duration = parseInt(durationSelect.value);
                const total = pricePerHour * duration;

                const formatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(total);

                totalDisplay.textContent = formatted;
            }

            studioSelect.addEventListener('change', calculateTotal);
            durationSelect.addEventListener('change', calculateTotal);
            calculateTotal();
        });
    </script>
</x-app-layout>
