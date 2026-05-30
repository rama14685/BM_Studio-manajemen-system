<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
                {{ __('Buku Kas / Keuangan') }}
            </h2>
            <a href="{{ route('admin.finances.create') }}" class="inline-flex items-center px-5 py-3 bg-[#FFC700] hover:bg-[#E14D2A] text-black hover:text-white border-[3px] border-black font-heading text-xs uppercase tracking-widest shadow-[3px_3px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                Tambah Transaksi Manual
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

            <!-- Filters -->
            <div class="bg-white border-[3px] border-black p-6 shadow-[4px_4px_0px_0px_black]">
                <h3 class="font-heading text-lg uppercase tracking-wide border-b-2 border-black pb-2 mb-4">🔍 FILTER LAPORAN KAS</h3>
                <form method="GET" action="{{ route('admin.finances.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-end">
                    <div>
                        <x-input-label for="type" :value="__('Tipe Transaksi')" class="text-black font-bold text-xs" />
                        <select name="type" id="type" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2px_2px_0px_0px_black]">
                            <option value="">Semua Tipe</option>
                            <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Pemasukan (Masuk)</option>
                            <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran (Keluar)</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="category" :value="__('Kategori')" class="text-black font-bold text-xs" />
                        <select name="category" id="category" class="mt-1 block w-full border-[3px] border-[#0D0D0D] bg-white text-black focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2px_2px_0px_0px_black]">
                            <option value="">Semua Kategori</option>
                            <option value="booking" {{ request('category') === 'booking' ? 'selected' : '' }}>Sewa Studio</option>
                            <option value="electricity" {{ request('category') === 'electricity' ? 'selected' : '' }}>Listrik</option>
                            <option value="drinks_stock" {{ request('category') === 'drinks_stock' ? 'selected' : '' }}>Minuman</option>
                            <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Lain-Lain</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="w-full inline-flex justify-center items-center py-3 bg-[#FFC700] border-[3px] border-black text-black font-heading text-xs uppercase tracking-widest shadow-[2px_2px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                            Filter Keuangan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Ledger Table -->
            <div class="bg-white border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_black]">
                @if($finances->isEmpty())
                    <p class="text-center text-zinc-500 font-bold py-12">[ BELUM ADA DATA TRANSAKSI KAS ]</p>
                @else
                    <div class="overflow-x-auto border-[3px] border-black">
                        <table class="min-w-full divide-y-2 divide-black text-left text-sm">
                            <thead>
                                <tr class="bg-[#FFC700] text-black font-heading uppercase text-xs tracking-wider border-b-2 border-black">
                                    <th class="px-6 py-4 border-r-2 border-black">Tanggal</th>
                                    <th class="px-6 py-4 border-r-2 border-black">Tipe</th>
                                    <th class="px-6 py-4 border-r-2 border-black">Kategori</th>
                                    <th class="px-6 py-4 border-r-2 border-black">Deskripsi</th>
                                    <th class="px-6 py-4 border-r-2 border-black">Jumlah</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-2 divide-black bg-[#F4F1EA] font-mono text-xs font-bold">
                                @foreach($finances as $finance)
                                    <tr class="hover:bg-white transition-colors duration-100">
                                        <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap text-zinc-650">
                                            {{ Carbon\Carbon::parse($finance->date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap font-sans">
                                            <span class="px-2.5 py-0.5 text-[10px] font-heading border-2 border-black shadow-[1.5px_1.5px_0px_0px_black] uppercase
                                                {{ $finance->type === 'income' ? 'bg-[#39FF14] text-black' : 'bg-[#E14D2A] text-white' }}">
                                                {{ $finance->type === 'income' ? 'Masuk' : 'Keluar' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap text-black uppercase">
                                            @if($finance->category === 'booking') Sewa Studio
                                            @elseif($finance->category === 'electricity') Listrik
                                            @elseif($finance->category === 'drinks_stock') Minuman
                                            @else Lain-Lain
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 border-r-2 border-black font-sans font-medium">
                                            {{ $finance->description }}
                                        </td>
                                        <td class="px-6 py-4 border-r-2 border-black whitespace-nowrap text-sm
                                            {{ $finance->type === 'income' ? 'text-green-600' : 'text-[#E14D2A]' }}">
                                            {{ $finance->type === 'income' ? '+' : '-' }} Rp {{ number_format($finance->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-[10px] font-heading space-x-1.5 font-bold font-sans">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.finances.edit', $finance->id) }}" class="px-2.5 py-1 bg-white border-2 border-black text-black shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">EDIT</a>
                                                
                                                <form action="{{ route('admin.finances.destroy', $finance->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus catatan keuangan ini?')">
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
                        {{ $finances->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
