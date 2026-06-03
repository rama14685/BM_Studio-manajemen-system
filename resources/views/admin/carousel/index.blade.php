<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
            {{ __('Carousel CMS') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen text-[#0D0D0D]"
         x-data="{
            isEditMode: false,
            formAction: '{{ route('admin.carousel.store') }}',
            itemId: null,
            title: '',
            description: '',
            imageRequired: true,

            resetForm() {
                this.isEditMode = false;
                this.formAction = '{{ route('admin.carousel.store') }}';
                this.itemId = null;
                this.title = '';
                this.description = '';
                this.imageRequired = true;
                
                // Clear file input manually
                document.getElementById('image').value = '';
            },

            editItem(item) {
                this.isEditMode = true;
                this.formAction = '/admin/carousel/' + item.id + '/update';
                this.itemId = item.id;
                this.title = item.title;
                this.description = item.description || '';
                this.imageRequired = false;
                
                // Scroll to form smoothly
                document.getElementById('form-card').scrollIntoView({ behavior: 'smooth' });
            }
         }">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Alert Notifications -->
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

            @if ($errors->any())
                <div class="bg-[#E14D2A] border-[3px] border-black p-5 shadow-[4px_4px_0px_0px_black] text-white font-mono font-bold text-sm">
                    <p class="font-heading mb-2">⚠️ PROSES GAGAL, SILAKAN PERIKSA INPUTAN:</p>
                    <ul class="list-disc list-inside text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- 1. CAROUSEL SLIDES LIST (8 columns) -->
                <div class="lg:col-span-8 bg-white border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_black] space-y-6">
                    <div class="flex justify-between items-center border-b-2 border-black pb-3">
                        <h3 class="font-heading text-2xl uppercase tracking-wider">
                            Slide Carousel Aktif
                        </h3>
                        <span class="px-3 py-1 bg-[#FFC700] border-2 border-black font-heading text-xs uppercase shadow-[2px_2px_0px_0px_black] tracking-wider">
                            {{ $carouselItems->count() }} SLIDES
                        </span>
                    </div>

                    @if($carouselItems->isEmpty())
                        <div class="text-center py-16 text-zinc-500 font-bold font-mono">
                            [ BELUM ADA SLIDE CAROUSEL AKTIF. LANDING PAGE AKAN KOSONG ]
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($carouselItems as $item)
                                <div class="bg-[#F4F1EA] border-[3px] border-black p-4 shadow-[4px_4px_0px_0px_black] hover:border-[#FFC700] transition-all relative flex flex-col justify-between h-96">
                                    <div>
                                        <!-- Image Preview container -->
                                        <div class="w-full h-44 bg-zinc-950 border-[2.5px] border-black mb-3 relative flex items-center justify-center overflow-hidden">
                                            @if($item->image_path)
                                                <img src="{{ $item->image_path }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                            @else
                                                <!-- Fallback svg -->
                                                <svg class="absolute inset-0 w-full h-full text-zinc-800" fill="none" viewBox="0 0 100 100">
                                                    <line x1="0" y1="50" x2="100" y2="50" stroke="currentColor" stroke-width="0.5"/>
                                                    <line x1="50" y1="0" x2="50" y2="100" stroke="currentColor" stroke-width="0.5"/>
                                                    <circle cx="50" cy="50" r="30" stroke="currentColor" stroke-width="0.5" stroke-dasharray="2"/>
                                                </svg>
                                                <span class="font-heading text-4xl text-[#FFC700] select-none opacity-85">📷</span>
                                            @endif
                                        </div>

                                        <!-- Title & Description details -->
                                        <h4 class="font-heading text-base uppercase text-black leading-tight truncate mb-1">{{ $item->title }}</h4>
                                        <p class="text-xs font-mono font-bold text-zinc-500 line-clamp-3 leading-relaxed">
                                            {{ $item->description }}
                                        </p>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center justify-between border-t border-black/10 pt-3 mt-3">
                                        <!-- Edit trigger -->
                                        <button 
                                            @click="editItem({{ json_encode($item) }})"
                                            class="px-3 py-1 bg-white border-2 border-black text-black font-heading text-[10px] uppercase shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all cursor-pointer"
                                        >
                                            EDIT
                                        </button>
                                        
                                        <!-- Destroy slide form -->
                                        <form action="{{ route('admin.carousel.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus slide carousel ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="px-3 py-1 bg-[#E14D2A] border-2 border-black text-white font-heading text-[10px] uppercase shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all cursor-pointer"
                                            >
                                                HAPUS
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- 2. ADD / EDIT CAROUSEL ITEM FORM (4 columns) -->
                <div id="form-card" class="lg:col-span-4 bg-white border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_black] space-y-5">
                    
                    <div class="flex justify-between items-center border-b-2 border-black pb-2">
                        <h3 class="font-heading text-lg uppercase tracking-wide" x-text="isEditMode ? 'Edit Slide' : 'Tambah Slide'">
                            Tambah Slide
                        </h3>
                        <button 
                            x-show="isEditMode" 
                            @click="resetForm()" 
                            class="px-2 py-0.5 bg-white border-2 border-black text-xs font-mono font-bold shadow-[1px_1px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all cursor-pointer"
                        >
                            BATAL
                        </button>
                    </div>

                    <form method="POST" :action="formAction" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Judul Slide (Title)</label>
                            <input type="text" name="title" x-model="title" required placeholder="Contoh: Studio Room Cozy"
                                class="w-full border-[3px] border-black bg-white text-black p-2.5 focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]">
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Deskripsi / Detail Studio</label>
                            <textarea name="description" x-model="description" rows="4" placeholder="Masukkan spesifikasi atau deskripsi slide..."
                                class="w-full border-[3px] border-black bg-white text-black p-2.5 focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black] font-mono text-xs font-bold"></textarea>
                        </div>

                        <!-- Image File Upload -->
                        <div class="bg-[#F4F1EA] border-[3px] border-black p-4 space-y-3 shadow-[2.5px_2.5px_0px_0px_black]">
                            <label class="block text-xs font-bold uppercase">
                                File Foto / Gambar
                                <span class="text-[10px] text-zinc-550 lowercase" x-text="isEditMode ? '(kosongkan jika tidak ingin diubah)' : '(wajib diisi)'"></span>
                            </label>
                            
                            <input type="file" id="image" name="image" :required="imageRequired" accept="image/*"
                                class="w-full text-xs font-mono font-bold text-zinc-500 file:mr-4 file:py-2 file:px-4 file:border-[2px] file:border-black file:bg-[#FFC700] file:text-black file:font-heading file:text-[10px] file:uppercase file:cursor-pointer hover:file:bg-[#FFC700]/95 hover:file:shadow-none transition-all">
                            
                            <p class="text-[9px] font-mono font-bold text-zinc-500 uppercase leading-tight mt-1">
                                Format: JPEG, PNG, JPG, GIF, SVG. Max: 4MB.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                            class="w-full py-3.5 bg-[#FFC700] border-[3px] border-black text-black font-heading text-xs uppercase tracking-widest shadow-[3px_3px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all cursor-pointer">
                            <span x-text="isEditMode ? 'Simpan Perubahan' : 'Unggah Slide Baru'"></span>
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
