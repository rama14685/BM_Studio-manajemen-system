<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-heading text-4xl text-[#0D0D0D] tracking-wider uppercase drop-shadow-[1px_1px_0px_white]">
                {{ __('Chat Admin Support') }}
            </h2>
            
            @php
                // Format phone number to international wa.me format
                $phone = $admin->phone;
                if (str_starts_with($phone, '0')) {
                    $phone = '62' . substr($phone, 1);
                }
            @endphp
            <a href="https://wa.me/{{ $phone }}" target="_blank" class="inline-flex items-center px-4 py-2.5 bg-[#FFC700] hover:bg-[#E14D2A] text-black hover:text-white border-[2.5px] border-black font-heading text-xs uppercase tracking-widest shadow-[2.5px_2.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.66.986 3.284 1.488 4.966 1.489 5.485.002 9.948-4.457 9.95-9.943.002-2.657-1.03-5.155-2.91-7.038C16.772 1.777 14.28 1.74 12.012 1.74c-5.487 0-9.95 4.457-9.952 9.944-.001 2.005.525 3.96 1.517 5.674l-.99 3.61 3.731-.977zm11.302-6.855c-.29-.145-1.716-.847-1.978-.942-.262-.096-.453-.145-.644.145-.191.29-.738.942-.905 1.134-.167.19-.334.217-.624.072-2.825-1.415-4.664-3.415-5.366-4.622-.27-.463-.03-.71.202-.94.208-.207.462-.538.693-.807.23-.268.307-.46.46-.767.153-.307.077-.575-.038-.767-.115-.192-.905-2.184-1.242-2.997-.33-.79-.66-.682-.905-.694-.232-.012-.497-.015-.762-.015-.266 0-.698.1-1.064.498-.366.4-1.398 1.367-1.398 3.33 0 1.963 1.428 3.856 1.628 4.123.197.268 2.81 4.29 6.802 6.015 2.128.92 3.328.784 4.092.67.92-.136 2.81-1.148 3.202-2.26.39-1.112.39-2.066.273-2.26-.117-.193-.413-.338-.703-.483z"/></svg>
                Hubungi via WhatsApp
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F4F1EA]">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-[3px] border-[#0D0D0D] shadow-[5px_5px_0px_0px_black] flex flex-col h-[600px]">
                
                <!-- Chat Header -->
                <div class="px-6 py-4 bg-[#FFC700] border-b-[3px] border-black flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 border-2 border-black bg-white flex items-center justify-center font-heading text-sm uppercase shadow-[1.5px_1.5px_0px_0px_black]">
                            AD
                        </div>
                        <div>
                            <h3 class="font-heading text-sm uppercase tracking-wide text-black">Admin BM Studio</h3>
                            <span class="text-[10px] text-zinc-950 font-bold flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-1.5 animate-pulse border border-black"></span> Online (Sistem Web)
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Chat Messages Scroll Container -->
                <div id="chat-messages" class="flex-1 p-6 overflow-y-auto bg-[#F4F1EA] space-y-4">
                    @if($messages->isEmpty())
                        <div id="no-messages-prompt" class="text-center text-zinc-500 font-bold py-24 text-xs space-y-2">
                            <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="font-heading uppercase text-sm mt-2">[ BELUM ADA CHAT ]</p>
                            <p>Mulai obrolan Anda dengan Admin BM Studio mengenai penyewaan atau minuman.</p>
                        </div>
                    @else
                        @foreach($messages as $msg)
                            @include('chat.partials.message_bubble', ['msg' => $msg])
                        @endforeach
                    @endif
                </div>

                <!-- Chat Input Form -->
                <div class="p-4 bg-white border-t-[3px] border-black">
                    <form id="chat-form" class="flex space-x-3">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $admin->id }}">
                        
                        <input type="text" id="chat-message-input" name="message" placeholder="Tulis pesan Anda di sini..." autocomplete="off" required
                            class="flex-1 border-[2.5px] border-[#0D0D0D] bg-white text-black font-bold text-sm focus:border-[#FFC700] focus:ring-0 rounded-none shadow-[3.5px_3.5px_0px_0px_black] px-4 py-3">
                        
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#FFC700] border-[2.5px] border-black text-black font-heading text-sm uppercase tracking-wider shadow-[3.5px_3.5px_0px_0px_black] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 active:shadow-none transition-all">
                            SEND
                        </button>
                    </form>
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
            const otherUserId = "{{ $admin->id }}";

            // Scroll chat to bottom
            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
            scrollToBottom();

            // Handle Message Submission via AJAX
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const msgText = chatInput.value.trim();
                if (!msgText) return;

                const formData = new FormData(chatForm);

                // Clear input early
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
                        
                        // Append message
                        chatMessages.insertAdjacentHTML('beforeend', data.html);
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    chatInput.value = msgText; // restore on error
                });
            });

            // Polling for incoming messages every 3 seconds
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
