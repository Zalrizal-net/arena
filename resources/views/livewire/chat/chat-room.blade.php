<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 h-[calc(100vh-100px)] flex flex-col">
    <div class="bg-white px-6 py-4 border-b border-gray-200 rounded-t-xl shadow-sm flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('chat.list') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-lg font-bold text-gray-900">Ruang Percakapan</h2>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-6 bg-gray-50 flex flex-col space-y-4 shadow-inner" id="chat-container">
        @forelse($chatMessages as $msg)
            @if($msg->sender_id === Auth::id())
                <div class="flex justify-end">
                    <div class="bg-[#076f60] text-white rounded-l-xl rounded-tr-xl px-5 py-3 max-w-[75%] shadow-sm">
                        <p class="text-sm">{{ $msg->message }}</p>
                        <p class="text-[10px] text-green-200 mt-1 text-right">{{ $msg->created_at->format('H:i') }}</p>
                    </div>
                </div>
            @else
                <div class="flex justify-start">
                    <div class="bg-white border border-gray-100 text-gray-800 rounded-r-xl rounded-tl-xl px-5 py-3 max-w-[75%] shadow-sm">
                        <p class="text-sm">{{ $msg->message }}</p>
                        <p class="text-[10px] text-gray-400 mt-1 text-right">{{ $msg->created_at->format('H:i') }}</p>
                    </div>
                </div>
            @endif
        @empty
            <div class="flex-1 flex items-center justify-center text-gray-400 text-sm">
                Mulai percakapan sekarang...
            </div>
        @endforelse
    </div>

    <div class="bg-white px-4 py-4 rounded-b-xl shadow-sm border-t border-gray-200">
        <form wire:submit.prevent="sendMessage" class="flex items-center space-x-3">
            <input wire:model.defer="messageText" type="text" placeholder="Ketik pesan Anda di sini..." required class="flex-1 bg-gray-100 border-transparent rounded-full px-5 py-3 text-sm focus:ring-[#076f60] focus:border-[#076f60]">
            <button type="submit" class="bg-[#076f60] text-white rounded-full p-3 hover:bg-[#05574b] transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#076f60]">
                <svg class="w-5 h-5 translate-x-[1px] translate-y-[-1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </form>
    </div>

    <script type="module">
        document.addEventListener('livewire:load', function () {
            // Fungsi Auto-scroll
            const container = document.getElementById('chat-container');
            container.scrollTop = container.scrollHeight;
            
            Livewire.hook('message.processed', () => {
                container.scrollTop = container.scrollHeight;
            });

            // Fungsi Realtime Echo (Menunggu Vite selesai)
            if (window.Echo) {
                console.log("Echo berhasil dimuat! Mencoba masuk ke room: " + {{ $roomId }});
                
                window.Echo.private('chat.' + {{ $roomId }})
                    .listen('.MessageSent', (e) => {
                        console.log('Pesan baru tertangkap JS:', e);
                        // Perintahkan Livewire merefresh pesan
                        @this.call('refreshMessages');
                    })
                    .error((error) => {
                        console.error('Gagal masuk ke channel:', error);
                    });
            } else {
                console.error("Gawat, window.Echo masih belum terbaca oleh browser!");
            }
        });
    </script>

</div>