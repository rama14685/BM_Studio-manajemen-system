<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
            {{ __('Obrolan Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA] min-h-screen text-[#0D0D0D]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-[3px] border-[#0D0D0D] shadow-[6px_6px_0px_0px_black] grid grid-cols-1 md:grid-cols-12 h-[600px]">
                
                <!-- 1. LEFT PANEL: SWITCH USER (4 cols) -->
                <div class="md:col-span-4 border-r-[3px] border-[#0D0D0D] flex flex-col h-full bg-white">
                    <div class="p-4 border-b-2 border-[#0D0D0D] bg-[#F4F1EA]">
                        <a href="{{ route('admin.chat.index') }}" class="text-xs font-bold text-zinc-600 hover:text-[#E14D2A] flex items-center">&larr; Kembali ke Pusat Chat</a>
                        <h3 class="font-heading text-xs uppercase mt-3 tracking-widest text-[#0D0D0D]">Daftar Percakapan</h3>
                    </div>
                    <div class="flex-1 overflow-y-auto divide-y-2 divide-[#0D0D0D] bg-[#F4F1EA]">
                        @foreach($chatUsers as $cust)
                            <a href="{{ route('admin.chat.show', $cust->id) }}" 
                                class="p-4 flex items-center space-x-3 transition-colors duration-100 block
                                {{ $cust->id === $user->id 
                                    ? 'bg-[#FFC700] text-black font-bold border-b-2 border-black' 
                                    : 'bg-white hover:bg-[#FFC700]/30 text-[#0D0D0D]' }}">
                                <div class="w-8 h-8 border-2 border-black bg-white flex items-center justify-center font-heading text-sm uppercase shadow-[1px_1px_0px_0px_black]">
                                    {{ substr($cust->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-heading text-xs uppercase truncate">{{ $cust->name }}</h4>
                                    <p class="text-[9px] font-mono font-bold text-zinc-500 truncate mt-0.5">{{ $cust->email }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 2. MAIN PANEL: LIVE CHAT (8 cols) -->
                <div class="md:col-span-8 flex flex-col h-full">
                    
                    <!-- Active Chat Header -->
                    <div class="px-6 py-4 border-b-[3px] border-black flex items-center justify-between bg-[#FFC700]">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 border-2 border-black bg-white flex items-center justify-center font-heading text-base shadow-[1.5px_1.5px_0px_0px_black]">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-heading text-sm uppercase tracking-wide text-black">{{ $user->name }}</h3>
                                <p class="text-[9px] font-mono font-bold text-zinc-950">{{ $user->email }} • {{ $user->phone ?? 'Tanpa No HP' }}</p>
                            </div>
                        </div>

                        <!-- WhatsApp API button -->
                        @if($user->phone)
                            @php
                                $phone = $user->phone;
                                if (str_starts_with($phone, '0')) {
                                    $phone = '62' . substr($phone, 1);
                                }
                            @endphp
                            <a href="https://wa.me/{{ $phone }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-white hover:bg-[#E14D2A] text-black hover:text-white border-2 border-black font-heading text-[10px] uppercase tracking-wider shadow-[1.5px_1.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                                Hubungi via WA
                            </a>
                        @endif
                    </div>

                    <!-- Chat Message Area -->
                    <div id="chat-messages" class="flex-1 p-6 overflow-y-auto bg-[#F4F1EA] space-y-4">
                        @if($messages->isEmpty())
                            <div id="no-messages-prompt" class="text-center text-zinc-500 font-bold py-12 text-xs">
                                Belum ada obrolan dengan {{ $user->name }}.
                            </div>
                        @else
                            @foreach($messages as $msg)
                                @include('chat.partials.message_bubble', ['msg' => $msg])
                            @endforeach
                        @endif
                    </div>

                    <!-- Input Box -->
                    <div class="p-4 border-t-[3px] border-black bg-white">
                        <form id="chat-form" class="flex space-x-3">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                            
                            <input type="text" id="chat-message-input" name="message" placeholder="Ketik balasan Anda..." autocomplete="off" required
                                class="flex-1 border-[2.5px] border-[#0D0D0D] bg-white text-black font-bold text-xs focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[2.5px_2.5px_0px_0px_black] px-3 py-2.5">
                            
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-[#FFC700] border-[2.5px] border-black text-black font-heading text-xs uppercase tracking-wider shadow-[2.5px_2.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 active:shadow-none transition-all">
                                BALAS
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Live Chat AJAX Handling Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.getElementById('chat-messages');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-message-input');
            const noMessagesPrompt = document.getElementById('no-messages-prompt');
            const otherUserId = "{{ $user->id }}";

            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            scrollToBottom();

            // Submit Reply
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const msgText = chatInput.value.trim();
                if (!msgText) return;

                const formData = new FormData(chatForm);
                chatInput.value = '';

                fetch("{{ route('chat.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (noMessagesPrompt) {
                            noMessagesPrompt.remove();
                        }
                        chatMessages.insertAdjacentHTML('beforeend', data.html);
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    chatInput.value = msgText;
                });
            });

            // Polling replies
            setInterval(function() {
                fetch(`/chat/fetch/${otherUserId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            if (noMessagesPrompt && data.html.trim() !== '') {
                                noMessagesPrompt.remove();
                            }
                            const isAtBottom = chatMessages.scrollHeight - chatMessages.clientHeight <= chatMessages.scrollTop + 100;
                            chatMessages.innerHTML = data.html;
                            if (isAtBottom) {
                                scrollToBottom();
                            }
                        }
                    })
                    .catch(error => console.error('Error polling messages:', error));
            }, 3000);
        });
    </script>
</x-app-layout>
