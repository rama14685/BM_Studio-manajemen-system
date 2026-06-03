<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
            {{ __('Kelola Karyawan & Shift') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen text-[#0D0D0D]"
         x-data="{
            isEditMode: false,
            formAction: '{{ route('admin.employees.store') }}',
            employeeId: null,
            name: '',
            email: '',
            phone: '',
            shiftStart: '08:00',
            shiftEnd: '17:00',
            faceFeatures: '',
            password: '',
            resetForm() {
                this.isEditMode = false;
                this.formAction = '{{ route('admin.employees.store') }}';
                this.employeeId = null;
                this.name = '';
                this.email = '';
                this.phone = '';
                this.shiftStart = '08:00';
                this.shiftEnd = '17:00';
                this.faceFeatures = '';
                this.password = '';
            },

            editEmployee(emp) {
                this.isEditMode = true;
                this.formAction = '/admin/employees/' + emp.id;
                this.employeeId = emp.id;
                this.name = emp.name;
                this.email = emp.email;
                this.phone = emp.phone || '';
                
                // Crop H:i:s -> H:i
                this.shiftStart = emp.shift_start ? emp.shift_start.substring(0, 5) : '08:00';
                this.shiftEnd = emp.shift_end ? emp.shift_end.substring(0, 5) : '17:00';
                this.faceFeatures = emp.face_features || '';
                this.password = '';
                
                // Scroll to form smoothly
                document.getElementById('form-card').scrollIntoView({ behavior: 'smooth' });
            }
         }">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Alert notifications -->
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
                
                <!-- 1. EMPLOYEES TABLE (8 columns) -->
                <div class="lg:col-span-8 bg-white border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_black] space-y-6">
                    <div class="flex justify-between items-center border-b-2 border-black pb-3">
                        <h3 class="font-heading text-2xl uppercase tracking-wider">
                            Daftar Karyawan / Admin
                        </h3>
                        <span class="px-3 py-1 bg-white border-2 border-black font-mono text-xs font-bold shadow-[2px_2px_0px_0px_black]">
                            TOTAL: {{ $employees->count() }} ADMIN
                        </span>
                    </div>

                    @if($employees->isEmpty())
                        <div class="text-center py-16 text-zinc-500 font-bold font-mono">
                            [ BELUM ADA DATA KARYAWAN TERDAFTAR ]
                        </div>
                    @else
                        <div class="overflow-x-auto border-[3px] border-black">
                            <table class="min-w-full divide-y-2 divide-black text-left text-sm">
                                <thead>
                                    <tr class="bg-[#FFC700] text-black font-heading uppercase text-xs tracking-wider border-b-2 border-black">
                                        <th class="px-4 py-3.5 border-r-2 border-black">Nama / Kontak</th>
                                        <th class="px-4 py-3.5 border-r-2 border-black">Shift Kerja</th>
                                        <th class="px-4 py-3.5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y-2 divide-black bg-[#F4F1EA] font-mono text-xs font-bold">
                                    @foreach($employees as $emp)
                                        <tr class="hover:bg-white transition-colors duration-100">
                                            <!-- Name & Contacts -->
                                            <td class="px-4 py-4 border-r-2 border-black whitespace-nowrap">
                                                <div class="font-sans font-bold text-sm text-[#0D0D0D]">{{ $emp->name }}</div>
                                                <div class="text-[10px] text-zinc-500 mt-1 font-mono leading-none">{{ $emp->email }}</div>
                                                <div class="text-[10px] text-zinc-500 mt-0.5 font-mono leading-none">{{ $emp->phone ?? '-' }}</div>
                                            </td>
                                            
                                            <!-- Shift hours -->
                                            <td class="px-4 py-4 border-r-2 border-black whitespace-nowrap">
                                                @if($emp->shift_start && $emp->shift_end)
                                                    <span class="px-2 py-1 bg-white border border-black shadow-[1px_1px_0px_black] text-black">
                                                        {{ \Carbon\Carbon::parse($emp->shift_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($emp->shift_end)->format('H:i') }}
                                                    </span>
                                                @else
                                                    <span class="text-zinc-400 font-normal">Belum diatur</span>
                                                @endif
                                            </td>



                                            <!-- CRUD Actions -->
                                            <td class="px-4 py-4 whitespace-nowrap text-right font-heading">
                                                <div class="flex items-center justify-end gap-2">
                                                    <!-- Edit Action -->
                                                    <button 
                                                        @click="editEmployee({{ json_encode($emp) }})"
                                                        class="px-2.5 py-1 bg-white border-2 border-black text-black text-[10px] uppercase shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all cursor-pointer"
                                                    >
                                                        EDIT
                                                    </button>
                                                    
                                                    <!-- Delete Action -->
                                                    @if($emp->id !== Auth::id())
                                                        <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus karyawan ini secara permanen?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button 
                                                                type="submit" 
                                                                class="px-2.5 py-1 bg-[#E14D2A] border-2 border-black text-white text-[10px] uppercase shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all cursor-pointer"
                                                            >
                                                                HAPUS
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="px-2.5 py-1 bg-zinc-200 border-2 border-zinc-400 text-zinc-400 text-[10px] uppercase cursor-not-allowed select-none">
                                                            SELF
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- 2. ADD / EDIT EMPLOYEE FORM (4 columns) -->
                <div id="form-card" class="lg:col-span-4 bg-white border-[3px] border-black p-6 shadow-[5px_5px_0px_0px_black] space-y-5">
                    
                    <div class="flex justify-between items-center border-b-2 border-black pb-2">
                        <h3 class="font-heading text-lg uppercase tracking-wide" x-text="isEditMode ? 'Edit Karyawan' : 'Tambah Karyawan'">
                            Tambah Karyawan
                        </h3>
                        <button 
                            x-show="isEditMode" 
                            @click="resetForm()" 
                            class="px-2 py-0.5 bg-white border-2 border-black text-xs font-mono font-bold shadow-[1px_1px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all cursor-pointer"
                        >
                            BATAL
                        </button>
                    </div>

                    <form method="POST" :action="formAction" class="space-y-4">
                        @csrf
                        
                        <!-- Alpine Method Override for Edit Mode -->
                        <template x-if="isEditMode">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <!-- Hidden Biometric Data Descriptor -->
                        <input type="hidden" name="face_features" x-model="faceFeatures">

                        <!-- Employee Name -->
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" x-model="name" required placeholder="Nama Karyawan..."
                                class="w-full border-[3px] border-black bg-white text-black p-2.5 focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]">
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Email (Username Login)</label>
                            <input type="email" name="email" x-model="email" required placeholder="email@bmstudio.com"
                                class="w-full border-[3px] border-black bg-white text-black p-2.5 focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]">
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Nomor Telepon / WA</label>
                            <input type="text" name="phone" x-model="phone" required placeholder="08xxxxxxxxxx"
                                class="w-full border-[3px] border-black bg-white text-black p-2.5 focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]">
                        </div>

                        <!-- Password (conditional) -->
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">
                                Password
                                <span class="text-[10px] text-zinc-550 lowercase" x-text="isEditMode ? '(kosongkan jika tidak ingin diubah)' : '(wajib diisi)'"></span>
                            </label>
                            <input type="password" name="password" x-model="password" :required="!isEditMode" placeholder="password123"
                                class="w-full border-[3px] border-black bg-white text-black p-2.5 focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]">
                        </div>

                        <!-- Shift Times -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase mb-1">Jam Masuk Shift</label>
                                <input type="time" name="shift_start" x-model="shiftStart" required
                                    class="w-full border-[3px] border-black bg-white text-black p-2 focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase mb-1">Jam Pulang Shift</label>
                                <input type="time" name="shift_end" x-model="shiftEnd" required
                                    class="w-full border-[3px] border-black bg-white text-black p-2 focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black]">
                            </div>
                        </div>



                        <!-- Submit CTA -->
                        <button type="submit" 
                            class="w-full py-3.5 bg-[#FFC700] border-[3px] border-black text-black font-heading text-xs uppercase tracking-widest shadow-[3px_3px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all cursor-pointer">
                            <span x-text="isEditMode ? 'Simpan Perubahan' : 'Daftarkan Karyawan'"></span>
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
