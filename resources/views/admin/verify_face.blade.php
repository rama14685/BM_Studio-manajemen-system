<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Presensi Kehadiran - BM Studio</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-heading { font-family: 'Syne', sans-serif; font-weight: 800; }
        @keyframes pulse-custom {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        .pulse-dot { animation: pulse-custom 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
</head>
<body class="bg-[#F4F1EA] text-[#0D0D0D] min-h-screen flex flex-col justify-center items-center p-4 selection:bg-[#FFC700] selection:text-[#0D0D0D]">

    <div class="max-w-md w-full bg-white border-[4px] border-[#0D0D0D] p-6 shadow-[8px_8px_0px_0px_#0D0D0D] space-y-6"
         x-data="{
            isSubmitting: false,
            errorMessage: '',
            successMessage: '',
            currentTime: '',

            init() {
                this.updateTime();
                setInterval(() => {
                    this.updateTime();
                }, 1000);
            },

            updateTime() {
                const now = new Date();
                this.currentTime = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            },

            submitPresence() {
                this.errorMessage = '';
                this.successMessage = '';
                this.isSubmitting = true;

                fetch('{{ route('admin.verify-face.post') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    this.isSubmitting = false;
                    if (data.status === 'success') {
                        this.successMessage = data.message;
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    } else {
                        this.errorMessage = data.message;
                    }
                })
                .catch(err => {
                    this.isSubmitting = false;
                    this.errorMessage = 'Gagal menghubungi server presensi.';
                });
            }
         }">

        <!-- Logo / Header -->
        <div class="text-center">
            <span class="px-3 py-1 bg-[#FFC700] border-2 border-black font-heading text-xs uppercase shadow-[2px_2px_0px_0px_black] tracking-widest inline-block">
                PRESENSI KEHADIRAN
            </span>
            <h1 class="font-heading text-3xl uppercase tracking-wider mt-3">MASUK SHIFT</h1>
            <p class="text-xs text-zinc-500 font-bold uppercase mt-1">Konfirmasi Kehadiran Karyawan & Mulai Kerja</p>
        </div>

        <!-- Alert messages -->
        <template x-if="errorMessage">
            <div class="bg-[#E14D2A] border-[3px] border-black p-4 text-white font-mono text-xs font-bold shadow-[3px_3px_0px_0px_black]">
                ⚠️ <span x-text="errorMessage"></span>
            </div>
        </template>

        <template x-if="successMessage">
            <div class="bg-[#39FF14] border-[3px] border-black p-4 text-black font-mono text-xs font-bold shadow-[3px_3px_0px_0px_black]">
                🤘 <span x-text="successMessage"></span>
            </div>
        </template>

        <!-- Dynamic Clock Display -->
        <div class="bg-zinc-950 border-[3px] border-black p-5 text-center shadow-[4px_4px_0px_0px_rgba(13,13,13,1)]">
            <div class="text-[10px] font-mono text-[#FFC700] uppercase tracking-widest mb-1 font-bold">WAKTU SAAT INI</div>
            <div class="font-heading text-4xl text-white tracking-widest font-bold" x-text="currentTime">--:--:--</div>
        </div>

        <!-- Employee Info Card -->
        <div class="border-[3px] border-black bg-[#F4F1EA] p-4 space-y-3 shadow-[4px_4px_0px_0px_rgba(13,13,13,1)]">
            <div class="flex justify-between items-center border-b-2 border-black pb-2">
                <span class="text-xs font-heading uppercase tracking-wide">Detail Karyawan</span>
                <span class="flex h-2 w-2 relative">
                    <span class="pulse-dot absolute inline-flex h-full w-full rounded-full bg-[#E14D2A] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#E14D2A]"></span>
                </span>
            </div>
            
            <div class="font-mono text-xs space-y-1.5 font-bold">
                <div class="flex justify-between">
                    <span class="text-zinc-500">NAMA:</span>
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-500">EMAIL:</span>
                    <span>{{ Auth::user()->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-zinc-500">JADWAL SHIFT:</span>
                    <span class="px-1.5 py-0.5 bg-white border border-black text-[10px]">
                        {{ Auth::user()->shift_start ? \Carbon\Carbon::parse(Auth::user()->shift_start)->format('H:i') : '00:00' }} - {{ Auth::user()->shift_end ? \Carbon\Carbon::parse(Auth::user()->shift_end)->format('H:i') : '00:00' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="bg-[#FFC700]/10 border-2 border-black p-3 font-mono text-[10px] font-bold space-y-1">
            <p>1. Klik tombol di bawah untuk mencatat kehadiran Anda.</p>
            <p>2. Jam mulai shift Anda akan diset otomatis saat tombol ditekan.</p>
            <p>3. Setelah berhasil, Anda akan dialihkan ke Dashboard utama.</p>
        </div>

        <!-- Confirm CTA -->
        <div class="flex flex-col space-y-3">
            <button 
                @click="submitPresence()" 
                :disabled="isSubmitting"
                class="w-full py-4 bg-[#FFC700] hover:bg-[#FFC700]/90 border-[3px] border-[#0D0D0D] text-black font-heading text-sm uppercase tracking-wider shadow-[4px_4px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all text-center font-extrabold cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span x-show="!isSubmitting">HADIR & MULAI SHIFT</span>
                <span x-show="isSubmitting">MEMPROSES PRESENSI...</span>
            </button>

            <!-- Cancel / Exit -->
            <form method="POST" action="{{ route('logout') }}" class="w-full text-center">
                @csrf
                <button type="submit" class="w-full py-2 bg-white hover:bg-zinc-100 border-[3px] border-[#0D0D0D] text-black font-heading text-xs uppercase tracking-wider shadow-[2px_2px_0px_0px_#0D0D0D] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all cursor-pointer">
                    KEMBALI / LOGOUT
                </button>
            </form>
        </div>
    </div>

</body>
</html>
