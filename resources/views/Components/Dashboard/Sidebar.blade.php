@php
    // Mengambil role user yang sedang login
    $role = auth()->user()->role ?? 'guest';
    
    // Variabel class CSS bawaan Anda
    $baseClass = "group flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors mb-1";
    $activeClass = "bg-[#04433a] text-white shadow-sm";
    $inactiveClass = "text-gray-100 hover:bg-[#066154] hover:text-white";
@endphp

<aside class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-[#076f60] shadow-lg hidden md:flex shrink-0">
    
    <div class="flex items-center justify-center mb-8">
        <h2 class="text-2xl font-extrabold text-white tracking-wide">Arena</h2>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-4">
        <nav class="space-y-1">
            
            @if ($role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? $activeClass : $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ Route::is('admin.dashboard') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="#" class="{{ $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Verifikasi Penjual
                </a>
                <a href="#" class="{{ $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Manajemen Pengguna
                </a>
            @endif

            @if ($role === 'seller')
                <a href="{{ route('seller.dashboard') }}" class="{{ Route::is('seller.dashboard') ? $activeClass : $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ Route::is('seller.dashboard') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('seller.facilities.index') ?? '#' }}" class="{{ Route::is('seller.facilities.index') ? $activeClass : $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Kelola Jadwal & Lapangan
                </a>
                <a href="{{ route('bookings.index') }}" class="{{ Route::is('bookings.index') ? $activeClass : $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Produk & Pesanan
                </a>
               
                <a href="{{ route('wallet.index') }}" class="{{ Route::is('wallet.index') ? $activeClass : $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                    Dompet Saya
                </a>
                <a href="{{ route('chat.list') }}" class="{{ Route::is('chat.*') ? $activeClass : $inactiveClass }} {{ $baseClass }} flex items-center justify-between group">
                    <div class="flex items-center">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ Route::is('chat.*') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        
                        {{ auth()->user()->role === 'seller' ? 'Pesan Masuk' : 'Chat Saya' }}
                    </div>

                    @livewire('chat.unread-badge')
                </a>
            @endif

            @if ($role === 'buyer')
                <a href="{{ route('buyer.dashboard') }}" class="{{ Route::is('buyer.dashboard') ? $activeClass : $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ Route::is('buyer.dashboard') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('booking.history') }}" class="{{ Route::is('buyer.bookings') ? $activeClass : $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ Route::is('buyer.bookings') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Booking Saya
                </a>
                
               
                
                <a href="{{ Route::has('buyer.notifications') ? route('buyer.notifications') : '#' }}" class="{{ Route::is('buyer.notifications') ? $activeClass : $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ Route::is('buyer.notifications') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Notifikasi Saya
                </a>
                <a href="{{ route('chat.list') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-[#076f60] transition-colors rounded-md hover:bg-gray-50">
                    <svg class="h-5 w-5 mr-2 text-gray-400 group-hover:text-[#076f60]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    
                    Chat Saya
                    
                    <span class="ml-2">
                        @livewire('chat.unread-badge')
                    </span>
                </a>

                <a href="{{ route('buyer.profile') }}" class="{{ Route::is('buyer.cart') ? $activeClass : $inactiveClass }} {{ $baseClass }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ Route::is('buyer.cart') ? 'text-white' : 'text-gray-300 group-hover:text-white' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Profile
                </a>
            @endif

        </nav>

        <div class="mt-8 pt-4 border-t border-[#066154]">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="group flex items-center w-full px-4 py-2.5 text-sm font-medium text-red-300 rounded-lg transition-colors hover:bg-red-600 hover:text-white">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 text-red-300 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </div>
</aside>