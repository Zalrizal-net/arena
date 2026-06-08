<div class="relative group" wire:click="markAllAsRead">
    <button class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <div class="absolute right-0 w-80 mt-2 bg-white rounded-md shadow-xl overflow-hidden z-20 hidden group-hover:block border border-gray-100">
        <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 font-bold text-gray-700">
            Notifikasi Anda
        </div>
        <div class="max-h-64 overflow-y-auto no-scrollbar">
            @forelse(auth()->user()->notifications as $notification)
                <a href="{{ $notification->data['url'] }}" class="block px-4 py-3 border-b border-gray-100 hover:bg-gray-50 {{ $notification->read_at === null ? 'bg-[#e6f4f1]' : '' }}">
                    <p class="text-sm font-bold text-gray-900">{{ $notification->data['title'] }}</p>
                    <p class="text-xs text-gray-600 mt-1">{{ $notification->data['message'] }}</p>
                    <p class="text-[10px] text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                </a>
            @empty
                <div class="px-4 py-6 text-center text-sm text-gray-500">
                    Belum ada notifikasi baru.
                </div>
            @endforelse
        </div>
    </div>
</div>