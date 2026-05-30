<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
            {{ __('Edit Item Inventaris') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen text-[#0D0D0D]">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-[3px] border-[#0D0D0D] shadow-[6px_6px_0px_0px_black] p-6">
                <div class="text-[#0D0D0D]">
                    
                    <a href="{{ route('admin.inventories.index', ['type' => $inventory->type]) }}" class="inline-flex items-center text-sm text-zinc-600 hover:text-[#E14D2A] mb-6 font-bold">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Inventaris
                    </a>

                    <form method="POST" action="{{ route('admin.inventories.update', $inventory->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Nama Barang')" class="text-black font-bold text-sm" />
                            <input id="name" type="text" name="name" value="{{ old('name', $inventory->name) }}" required
                                class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]">
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <div>
                            <x-input-label for="stock_qty" :value="__('Jumlah Stok')" class="text-black font-bold text-sm" />
                            <input id="stock_qty" type="number" name="stock_qty" value="{{ old('stock_qty', $inventory->stock_qty) }}" min="0" required
                                class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]">
                            <x-input-error :messages="$errors->get('stock_qty')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        @if($inventory->type === 'drink')
                            <div>
                                <x-input-label for="price" :value="__('Harga Jual (Rupiah)')" class="text-black font-bold text-sm" />
                                <input id="price" type="number" name="price" value="{{ old('price', $inventory->price) }}" min="0" required
                                    class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]">
                                <x-input-error :messages="$errors->get('price')" class="mt-2 text-[#E14D2A] font-bold" />
                            </div>
                        @else
                            <div>
                                <x-input-label for="condition" :value="__('Kondisi Peralatan')" class="text-black font-bold text-sm" />
                                <select id="condition" name="condition" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3px_3px_0px_0px_black]" required>
                                    <option value="Baik" {{ old('condition', $inventory->condition) === 'Baik' ? 'selected' : '' }}>Baik (Normal)</option>
                                    <option value="Rusak" {{ old('condition', $inventory->condition) === 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                    <option value="Sedang Diperbaiki" {{ old('condition', $inventory->condition) === 'Sedang Diperbaiki' ? 'selected' : '' }}>Sedang Diperbaiki</option>
                                </select>
                                <x-input-error :messages="$errors->get('condition')" class="mt-2 text-[#E14D2A] font-bold" />
                            </div>
                        @endif

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-[#E14D2A] border-[3px] border-black text-white font-heading text-md uppercase tracking-wider shadow-[4px_4px_0px_0px_black] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">
                                {{ __('Perbarui Barang') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
