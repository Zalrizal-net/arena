<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Pesan Saya</h1>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <ul class="divide-y divide-gray-200">
            @forelse($rooms as $room)
                <li class="hover:bg-gray-50 transition-colors">
                    <a href="{{ route('chat.room', $room->id) }}" class="flex items-center px-6 py-4">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-[#076f60] flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr($role === 'seller' ? $room->buyer->name : $room->seller->name, 0, 1)) }}
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $role === 'seller' ? $room->buyer->name : $room->seller->name }}
                                </p>
                                @if($room->last_message_at)
                                    <p class="text-xs text-gray-500">{{ $room->last_message_at->diffForHumans() }}</p>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 mt-1">
                                Fasilitas: <span class="font-medium">{{ $room->facility?->name ?? 'Fasilitas Tidak Tersedia/Dihapus' }}</span>
                            </p>
                        </div>
                    </a>
                </li>
            @empty
                <li class="px-6 py-12 text-center text-gray-500">
                    Belum ada percakapan.
                </li>
            @endforelse
        </ul>
    </div>
</div>