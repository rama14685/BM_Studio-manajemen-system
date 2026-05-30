<div class="flex flex-col {{ $msg->sender_id === Auth::id() ? 'items-end' : 'items-start' }} mb-4">
    <div class="max-w-[75%] border-2 border-[#0D0D0D] px-4 py-2.5 text-sm shadow-[2px_2px_0px_0px_black]
        {{ $msg->sender_id === Auth::id() 
            ? 'bg-[#FFC700] text-black font-semibold' 
            : 'bg-white text-black' }}">
        <p class="whitespace-pre-wrap break-words leading-relaxed">{{ $msg->message }}</p>
    </div>
    <span class="text-[9px] font-mono font-bold text-zinc-500 mt-1 px-1">
        {{ $msg->created_at->setTimezone('Asia/Jakarta')->format('H:i') }}
    </span>
</div>
