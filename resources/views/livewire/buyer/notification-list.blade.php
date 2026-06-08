<div>
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Notifikasi Saya</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola semua pemberitahuan pesanan dan pembayaran Anda di sini.</p>
            </div>
            
            @if(auth()->user()->unreadNotifications->count() > 0)
                <button wire:click="markAllAsRead" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#076f60] transition">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Tandai Semua Dibaca
                </button>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            @if($notifications->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach($notifications as $notification)
                        <li class="p-4 sm:p-6 transition hover:bg-gray-50 {{ $notification->read_at === null ? 'bg-[#f4faf9]' : 'bg-white' }}">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 mt-1">
                                        @if($notification->read_at === null)
                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-[#076f60] text-white">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm sm:text-base font-bold {{ $notification->read_at === null ? 'text-gray-900' : 'text-gray-700' }}">
                                            {{ $notification->data['title'] ?? 'Pemberitahuan Baru' }}
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                            {{ $notification->data['message'] ?? 'Anda memiliki pesan baru.' }}
                                        </p>
                                        <div class="flex items-center gap-4 mt-3">
                                            <span class="text-xs font-medium text-gray-400 flex items-center">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                            @if(isset($notification->data['url']))
                                                <a href="{{ $notification->data['url'] }}" class="text-xs font-bold text-[#076f60] hover:text-[#05574b] transition">
                                                    Lihat Detail &rarr;
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row items-center gap-2">
                                    @if($notification->read_at === null)
                                        <button wire:click="markAsRead('{{ $notification->id }}')" class="p-2 text-gray-400 hover:text-[#076f60] bg-white rounded-full hover:bg-[#e6f4f1] transition tooltip" title="Tandai sudah dibaca">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    @endif
                                    <button wire:click="deleteNotification('{{ $notification->id }}')" class="p-2 text-gray-400 hover:text-red-600 bg-white rounded-full hover:bg-red-50 transition tooltip" title="Hapus notifikasi">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="px-6 py-4 border-t border-gray-100 bg-white">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="px-4 py-16 text-center">
                    <div class="mx-auto h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum ada notifikasi</h3>
                    <p class="mt-1 text-sm text-gray-500">Saat Anda memesan fasilitas atau menyelesaikan pembayaran, pemberitahuannya akan muncul di sini.</p>
                </div>
            @endif
        </div>
    </div>
</div>