<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
            {{ __('Pusat Chat Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen text-[#0D0D0D]">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-[3px] border-[#0D0D0D] shadow-[5px_5px_0px_0px_black] p-6 space-y-6">
                
                <h3 class="font-heading text-xl uppercase tracking-wider border-b-2 border-black pb-2">
                    Daftar Percakapan Pelanggan
                </h3>

                @if($chatUsers->isEmpty())
                    <p class="text-center text-zinc-500 font-bold py-12">[ BELUM ADA DATA PELANGGAN ]</p>
                @else
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($chatUsers as $cust)
                            <div class="p-4 bg-[#F4F1EA] border-[3px] border-black flex flex-col sm:flex-row items-start sm:items-center justify-between shadow-[3px_3px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all duration-150">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 border-2 border-black bg-[#FFC700] flex items-center justify-center font-heading text-lg uppercase shadow-[1.5px_1.5px_0px_0px_black]">
                                        {{ substr($cust->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center flex-wrap gap-2">
                                            <h4 class="font-heading text-base uppercase text-black">{{ $cust->name }}</h4>
                                            @if($cust->unread_count > 0)
                                                <span class="px-2 py-0.5 text-[9px] font-heading bg-[#E14D2A] text-white border border-black shadow-[1px_1px_0px_0px_black] animate-pulse">
                                                    {{ $cust->unread_count }} BARU
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs font-mono font-bold text-zinc-500 mt-1">{{ $cust->email }} • {{ $cust->phone ?? 'No HP' }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3 mt-4 sm:mt-0 w-full sm:w-auto justify-end">
                                    <!-- WhatsApp Direct Link -->
                                    @if($cust->phone)
                                        @php
                                            $phone = $cust->phone;
                                            if (str_starts_with($phone, '0')) {
                                                $phone = '62' . substr($phone, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $phone }}" target="_blank" 
                                            class="p-2 border-2 border-black bg-white hover:bg-[#39FF14] text-black shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all"
                                            title="Hubungi via WhatsApp">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.66.986 3.284 1.488 4.966 1.489 5.485.002 9.948-4.457 9.95-9.943.002-2.657-1.03-5.155-2.91-7.038C16.772 1.777 14.28 1.74 12.012 1.74c-5.487 0-9.95 4.457-9.952 9.944-.001 2.005.525 3.96 1.517 5.674l-.99 3.61 3.731-.977zm11.302-6.855c-.29-.145-1.716-.847-1.978-.942-.262-.096-.453-.145-.644.145-.191.29-.738.942-.905 1.134-.167.19-.334.217-.624.072-2.825-1.415-4.664-3.415-5.366-4.622-.27-.463-.03-.71.202-.94.208-.207.462-.538.693-.807.23-.268.307-.46.46-.767.153-.307.077-.575-.038-.767-.115-.192-.905-2.184-1.242-2.997-.33-.79-.66-.682-.905-.694-.232-.012-.497-.015-.762-.015-.266 0-.698.1-1.064.498-.366.4-1.398 1.367-1.398 3.33 0 1.963 1.428 3.856 1.628 4.123.197.268 2.81 4.29 6.802 6.015 2.128.92 3.328.784 4.092.67.92-.136 2.81-1.148 3.202-2.26.39-1.112.39-2.066.273-2.26-.117-.193-.413-.338-.703-.483z"/></svg>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.chat.show', $cust->id) }}" 
                                        class="px-4 py-2.5 border-2 border-black bg-[#FFC700] hover:bg-[#E14D2A] hover:text-white text-black font-heading text-xs uppercase tracking-wider shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                                        Buka Chat
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
