<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
            {{ __('Tambah Transaksi Manual') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen text-[#0D0D0D]">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-[3px] border-[#0D0D0D] shadow-[6px_6px_0px_0px_black] p-6">
                <div class="text-[#0D0D0D]">
                    
                    <a href="{{ route('admin.finances.index') }}" class="inline-flex items-center text-sm text-zinc-600 hover:text-[#E14D2A] mb-6 font-bold">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Keuangan
                    </a>

                    <form method="POST" action="{{ route('admin.finances.store') }}" class="space-y-6">
                        @csrf

                        <!-- Type Selection -->
                        <div>
                            <x-input-label for="type" :value="__('Tipe Transaksi')" class="text-black font-bold text-sm" />
                            <select id="type" name="type" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]" required>
                                <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Pemasukan (Masuk)</option>
                                <option value="expense" {{ old('type', 'expense') === 'expense' ? 'selected' : '' }}>Pengeluaran (Keluar)</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Category Selection -->
                        <div>
                            <x-input-label for="category" :value="__('Kategori')" class="text-black font-bold text-sm" />
                            <select id="category" name="category" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]" required>
                                <option value="booking" {{ old('category') === 'booking' ? 'selected' : '' }}>Sewa Studio (Pemasukan)</option>
                                <option value="drinks_stock" {{ old('category') === 'drinks_stock' ? 'selected' : '' }}>Restok Minuman / Penjualan</option>
                                <option value="electricity" {{ old('category') === 'electricity' ? 'selected' : '' }}>Listrik (Pengeluaran)</option>
                                <option value="other" {{ old('category', 'other') === 'other' ? 'selected' : '' }}>Lain-Lain</option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Amount Input -->
                        <div>
                            <x-input-label for="amount" :value="__('Jumlah Uang (Rupiah)')" class="text-black font-bold text-sm" />
                            <input id="amount" type="number" name="amount" value="{{ old('amount') }}" placeholder="Contoh: 150000" min="0.01" step="0.01" required
                                class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]">
                            <x-input-error :messages="$errors->get('amount')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Description Input -->
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi / Keterangan')" class="text-black font-bold text-sm" />
                            <textarea id="description" name="description" rows="3" placeholder="Contoh: Bayar listrik studio bulan Mei" required
                                class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Date Selection -->
                        <div>
                            <x-input-label for="date" :value="__('Tanggal Transaksi')" class="text-black font-bold text-sm" />
                            <input id="date" type="date" name="date" value="{{ old('date', now()->toDateString()) }}" required
                                class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]">
                            <x-input-error :messages="$errors->get('date')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-[#E14D2A] border-[3px] border-black text-white font-heading text-md uppercase tracking-wider shadow-[4px_4px_0px_0px_black] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">
                                {{ __('Simpan Catatan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
