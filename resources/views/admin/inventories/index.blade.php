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
                        @if($type === 'equipment')
                            <!-- Card-grid for equipment -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @foreach($items as $item)
                                    <div class="bg-[#F4F1EA] border-[3px] border-black p-4 shadow-[4px_4px_0px_0px_black] hover:border-[#E14D2A] transition-colors relative flex flex-col justify-between h-72">
                                        <div>
                                            <!-- Raw image placeholder -->
                                            <div class="w-full h-32 bg-zinc-950 border-[2.5px] border-black mb-3 relative flex items-center justify-center overflow-hidden">
                                                <!-- Retro-style wireframe grid -->
                                                <svg class="absolute inset-0 w-full h-full text-zinc-800" fill="none" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                                    <line x1="0" y1="50" x2="100" y2="50" stroke="currentColor" stroke-width="0.5"/>
                                                    <line x1="50" y1="0" x2="50" y2="100" stroke="currentColor" stroke-width="0.5"/>
                                                    <circle cx="50" cy="50" r="30" stroke="currentColor" stroke-width="0.5" stroke-dasharray="2"/>
                                                </svg>
                                                <span class="font-heading text-4xl text-[#FFC700] select-none opacity-85">🎸</span>
                                            </div>

                                            <div class="flex justify-between items-start gap-2">
                                                <h4 class="font-heading text-sm uppercase text-black leading-tight">{{ $item->name }}</h4>
                                                <!-- Bold sticker-like condition status label -->
                                                <span class="px-2.5 py-0.5 text-[9px] font-heading border-2 border-black shadow-[1.5px_1.5px_0px_0px_black] uppercase whitespace-nowrap
                                                    @if($item->condition === 'Baik') bg-[#39FF14] text-black
                                                    @elseif($item->condition === 'Rusak') bg-[#E14D2A] text-white
                                                    @else bg-[#FFC700] text-black
                                                    @endif">
                                                    {{ $item->condition }}
                                                </span>
                                            </div>
                                            
                                            <p class="text-xs font-mono font-bold text-zinc-500 mt-2">STOK: {{ $item->stock_qty }} UNIT</p>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center justify-between border-t border-black/10 pt-3 mt-3">
                                            <a href="{{ route('admin.inventories.edit', $item->id) }}" class="px-3 py-1 bg-white border-2 border-black text-black font-heading text-[10px] uppercase shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">EDIT</a>
                                            
                                            <form action="{{ route('admin.inventories.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus item ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-[#E14D2A] border-2 border-black text-white font-heading text-[10px] uppercase shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">HAPUS</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Table for drinks stock -->
                            <div class="overflow-x-auto border-[3px] border-black">
                                <table class="min-w-full divide-y-2 divide-black text-left text-sm">
                                    <thead>
                                        <tr class="bg-[#FFC700] text-black font-heading uppercase text-xs tracking-wider border-b-2 border-black">
                                            <th class="px-6 py-4 border-r-2 border-black">Nama Barang</th>
                                            <th class="px-6 py-4 border-r-2 border-black text-center">Jumlah Stok</th>
                                            <th class="px-6 py-4 border-r-2 border-black">Harga Jual</th>
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
                                                    <!-- Fast adjust buttons -->
                                                    <div class="flex items-center justify-center space-x-3">
                                                        <form action="{{ route('admin.inventories.adjust', $item->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="adjustment" value="-1">
                                                            <button type="submit" class="w-6 h-6 border-2 border-black bg-white hover:bg-[#E14D2A] hover:text-white font-extrabold text-xs flex items-center justify-center shadow-[1px_1px_0px_0px_black] active:shadow-none active:translate-x-0.5 active:translate-y-0.5 transition-all cursor-pointer">-</button>
                                                        </form>
                                                        <span class="font-mono font-bold text-sm w-8 text-center">{{ $item->stock_qty }}</span>
                                                        <form action="{{ route('admin.inventories.adjust', $item->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="adjustment" value="1">
                                                            <button type="submit" class="w-6 h-6 border-2 border-black bg-white hover:bg-[#39FF14] font-extrabold text-xs flex items-center justify-center shadow-[1px_1px_0px_0px_black] active:shadow-none active:translate-x-0.5 active:translate-y-0.5 transition-all cursor-pointer">+</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap text-black font-sans">
                                                    <span class="font-bold text-sm text-[#E14D2A]">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
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
