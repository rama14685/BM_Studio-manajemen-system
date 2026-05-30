<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
            {{ __('Inventaris Studio') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen text-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Alert messages -->
            @if(session('success'))
                <div class="bg-[#39FF14] border-[3px] border-black p-5 shadow-[4px_4px_0px_0px_black] text-black font-mono font-bold text-sm transform -rotate-0.5">
                    🤘 SUCCESS: {{ strtoupper(session('success')) }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-[#E14D2A] border-[3px] border-black p-5 shadow-[4px_4px_0px_0px_black] text-white font-mono font-bold text-sm transform rotate-0.5">
                    ⚠️ ERROR: {{ strtoupper(session('error')) }}
                </div>
            @endif

            <!-- Tabs Selection (Neo-brutalist buttons style) -->
            <div class="flex flex-wrap gap-4 border-b-[3px] border-black pb-4">
                <a href="{{ route('admin.inventories.index', ['type' => 'drink']) }}" 
                    class="px-5 py-3 border-[3px] border-black font-heading text-xs uppercase tracking-wider transition-all
                    {{ $type === 'drink' 
                        ? 'bg-[#FFC700] text-black shadow-[3px_3px_0px_0px_black]' 
                        : 'bg-white hover:bg-[#FFC700] text-zinc-500 hover:text-black hover:shadow-[3px_3px_0px_0px_black] hover:-translate-x-0.5 hover:-translate-y-0.5' }}">
                    🥤 Stok Minuman (Kasir)
                </a>
                <a href="{{ route('admin.inventories.index', ['type' => 'equipment']) }}" 
                    class="px-5 py-3 border-[3px] border-black font-heading text-xs uppercase tracking-wider transition-all
                    {{ $type === 'equipment' 
                        ? 'bg-[#FFC700] text-black shadow-[3px_3px_0px_0px_black]' 
                        : 'bg-white hover:bg-[#FFC700] text-zinc-500 hover:text-black hover:shadow-[3px_3px_0px_0px_black] hover:-translate-x-0.5 hover:-translate-y-0.5' }}">
                    🎸 Peralatan Musik & Aset
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- 1. LEFT / MAIN: CRUD TABLE LIST (8 cols) -->
                <div class="lg:col-span-8 bg-white border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_black] space-y-4">
                    <h3 class="font-heading text-xl uppercase tracking-wider border-b-2 border-black pb-2">
                        Daftar {{ $type === 'drink' ? 'Stok Minuman' : 'Peralatan Musik' }}
                    </h3>

                    @if($items->isEmpty())
                        <p class="text-center text-zinc-500 font-bold py-12">[ BELUM ADA DATA INVENTARIS ]</p>
                    @else
                        <div class="overflow-x-auto border-[3px] border-black">
                            <table class="min-w-full divide-y-2 divide-black text-left text-sm">
                                <thead>
                                    <tr class="bg-[#FFC700] text-black font-heading uppercase text-xs tracking-wider border-b-2 border-black">
                                        <th class="px-6 py-4 border-r-2 border-black">Nama Barang</th>
                                        <th class="px-6 py-4 border-r-2 border-black text-center">Jumlah Stok</th>
                                        @if($type === 'drink')
                                            <th class="px-6 py-4 border-r-2 border-black">Harga Jual</th>
                                        @else
                                            <th class="px-6 py-4 border-r-2 border-black">Kondisi</th>
                                        @endif
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y-2 divide-black bg-[#F4F1EA] font-mono text-xs font-bold">
                                    @foreach($items as $item)
                                        <tr class="hover:bg-white transition-colors duration-100">
                                            <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap font-sans font-bold text-sm">
                                                {{ $item->name }}
                                            </td>
                                            <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap text-center">
                                                @if($type === 'drink')
                                                    <!-- Fast adjust buttons -->
                                                    <div class="flex items-center justify-center space-x-3">
                                                        <form action="{{ route('admin.inventories.adjust', $item->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="adjustment" value="-1">
                                                            <button type="submit" class="w-6 h-6 border-2 border-black bg-white hover:bg-[#E14D2A] hover:text-white font-extrabold text-xs flex items-center justify-center shadow-[1px_1px_0px_0px_black] active:shadow-none active:translate-x-0.5 active:translate-y-0.5 transition-all">-</button>
                                                        </form>
                                                        <span class="font-mono font-bold text-sm w-8 text-center">{{ $item->stock_qty }}</span>
                                                        <form action="{{ route('admin.inventories.adjust', $item->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="adjustment" value="1">
                                                            <button type="submit" class="w-6 h-6 border-2 border-black bg-white hover:bg-[#39FF14] font-extrabold text-xs flex items-center justify-center shadow-[1px_1px_0px_0px_black] active:shadow-none active:translate-x-0.5 active:translate-y-0.5 transition-all">+</button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <span class="font-mono font-bold text-sm bg-white border border-black px-2 py-0.5">{{ $item->stock_qty }} Unit</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap text-black font-sans">
                                                @if($type === 'drink')
                                                    <span class="font-bold text-sm text-[#E14D2A]">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="px-2.5 py-0.5 text-[9px] font-heading border-2 border-black shadow-[1.5px_1.5px_0px_0px_black] uppercase
                                                        @if($item->condition === 'Baik') bg-[#39FF14] text-black
                                                        @elseif($item->condition === 'Rusak') bg-[#E14D2A] text-white
                                                        @else bg-[#FFC700] text-black
                                                        @endif">
                                                        {{ $item->condition }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-[10px] font-heading space-x-1.5 font-bold font-sans">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('admin.inventories.edit', $item->id) }}" class="px-2.5 py-1 bg-white border-2 border-black text-black shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">EDIT</a>
                                                    
                                                    <form action="{{ route('admin.inventories.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus item ini?')">
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
                    @endif
                </div>

                <!-- 2. RIGHT: INLINE QUICK CREATE FORM (4 cols) -->
                <div class="lg:col-span-4 bg-white border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_black]">
                    <h3 class="font-heading text-lg uppercase tracking-wide border-b-2 border-black pb-2 mb-4">
                        Tambah Item Baru
                    </h3>

                    <form method="POST" action="{{ route('admin.inventories.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">

                        <div>
                            <x-input-label for="name" :value="__('Nama Barang')" class="text-black font-bold text-xs" />
                            <input id="name" type="text" name="name" placeholder="Contoh: Coca-Cola / Kabel Jack" required
                                class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]">
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        <div>
                            <x-input-label for="stock_qty" :value="__('Jumlah Stok Awal')" class="text-black font-bold text-xs" />
                            <input id="stock_qty" type="number" name="stock_qty" min="0" required
                                class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]">
                            <x-input-error :messages="$errors->get('stock_qty')" class="mt-2 text-[#E14D2A] font-bold" />
                        </div>

                        @if($type === 'drink')
                            <div>
                                <x-input-label for="price" :value="__('Harga Jual (Rupiah)')" class="text-black font-bold text-xs" />
                                <input id="price" type="number" name="price" min="0" required
                                    class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]">
                                <x-input-error :messages="$errors->get('price')" class="mt-2 text-[#E14D2A] font-bold" />
                            </div>
                        @else
                            <div>
                                <x-input-label for="condition" :value="__('Kondisi Peralatan')" class="text-black font-bold text-xs" />
                                <select id="condition" name="condition" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]" required>
                                    <option value="Baik">Baik (Normal)</option>
                                    <option value="Rusak">Rusak</option>
                                    <option value="Sedang Diperbaiki">Sedang Diperbaiki</option>
                                </select>
                                <x-input-error :messages="$errors->get('condition')" class="mt-2 text-[#E14D2A] font-bold" />
                            </div>
                        @endif

                        <button type="submit" class="w-full inline-flex justify-center items-center py-3.5 bg-[#FFC700] border-[3px] border-black text-black font-heading text-xs uppercase tracking-widest shadow-[3px_3px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                            Tambah Barang
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
