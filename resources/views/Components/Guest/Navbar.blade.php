<nav class="bg-white border-b border-gray-200 sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <div class="flex items-center gap-8">
                <a href="/" class="text-2xl font-black text-[#076f60] tracking-wider uppercase">
                    ARENA
                </a>
                
                <div class="hidden md:flex items-center gap-6">
                    <a href="/" class="text-sm transition {{ request()->is('/') ? 'text-[#076f60] font-bold' : 'text-gray-500 font-semibold hover:text-[#076f60]' }}">
                        Beranda
                    </a>
                    
                    <a href="{{ route('facilities.index') ?? '#' }}" class="text-sm transition {{ request()->routeIs('facilities.*') ? 'text-[#076f60] font-bold' : 'text-gray-500 font-semibold hover:text-[#076f60]' }}">
                        Katalog Lapangan
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-4">
                
                @auth
                    <a href="{{ route('chat.list') }}" class="relative p-2 text-gray-400 hover:text-[#076f60] focus:outline-none transition group flex items-center">
                        <span class="sr-only">Pesan Masuk</span>
                        <svg class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        
                        <div class="absolute -top-1 -right-1 scale-75 origin-top-right">
                            @livewire('chat.unread-badge')
                        </div>
                    </a>

                    <a href="{{ route('buyer.notifications') }}" class="relative p-2 text-gray-400 hover:text-[#076f60] focus:outline-none transition group flex items-center">
                        <span class="sr-only">Lihat notifikasi</span>
                        <svg class="h-6 w-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white">
                                {{ auth()->user()->unreadNotifications->count() > 99 ? '99+' : auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>

                    <div x-data="{ open: false }" class="relative ml-2">
                        <button @click="open = !open" @click.away="open = false" type="button" class="flex items-center gap-2 focus:outline-none hover:bg-gray-50 p-1.5 rounded-full transition">
                            <div class="h-9 w-9 rounded-full bg-[#076f60] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-bold text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100" 
                             x-transition:enter-start="transform opacity-0 scale-95" 
                             x-transition:enter-end="transform opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="transform opacity-100 scale-100" 
                             x-transition:leave-end="transform opacity-0 scale-95" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 border border-gray-100 focus:outline-none" style="display: none;">
                            
                            <a href="{{ route('buyer.dashboard') ?? '#' }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#076f60] font-medium">Dasbor Saya</a>
                            
                            <div class="border-t border-gray-100 my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') ?? '#' }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">Keluar</button>
                            </form>
                        </div>
                    </div>

                @else
                    <a href="{{ route('login') ?? '#' }}" class="text-sm font-bold text-[#076f60] hover:text-[#05574b] px-4 py-2 transition">Masuk</a>
                    <a href="{{ route('register') ?? '#' }}" class="text-sm font-bold bg-[#076f60] text-white px-5 py-2.5 rounded-full hover:bg-[#05574b] transition shadow-sm">Daftar</a>
                @endauth
                
            </div>

        </div>
    </div>
</nav>