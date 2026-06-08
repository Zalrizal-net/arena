<div class="bg-white min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-6 text-sm text-gray-500 font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('landing') }}" class="hover:text-[#076f60] transition">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('facilities.index') }}" class="hover:text-[#076f60] transition">Fasilitas</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-gray-900 line-clamp-1">{{ $facility->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        @if (session()->has('success'))
            <div class="mb-6 p-4 text-sm text-[#05574b] bg-[#e6f4f1] rounded-xl border border-[#076f60]/30 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-2 text-[#076f60]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- KOLOM KIRI: Foto & Detail Fasilitas -->
            <div class="lg:col-span-2 space-y-10">
                
                <!-- Galeri Foto -->
                <div>
                    <!-- Foto Utama -->
                    <div class="relative h-[300px] md:h-[450px] w-full rounded-2xl overflow-hidden bg-gray-100 mb-4 shadow-sm border border-gray-100">
                        @if($mainImage)
                            <img src="{{ \Illuminate\Support\Str::startsWith($mainImage, ['http://', 'https://']) ? $mainImage : asset('storage/' . $mainImage) }}" alt="{{ $facility->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 00-2-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Foto Kecil (Thumbnails) -->
                    @if($facility->images && $facility->images->count() > 0)
                        <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar">
                            <button wire:click="setMainImage('{{ $facility->thumbnail }}')" class="flex-shrink-0 w-24 h-24 rounded-xl overflow-hidden border-2 {{ $mainImage === $facility->thumbnail ? 'border-[#076f60] ring-2 ring-[#076f60] ring-offset-1' : 'border-transparent opacity-60 hover:opacity-100' }} transition-all duration-200">
                                <img src="{{ \Illuminate\Support\Str::startsWith($facility->thumbnail, ['http://', 'https://']) ? $facility->thumbnail : asset('storage/' . $facility->thumbnail) }}" class="w-full h-full object-cover">
                            </button>
                            
                            @foreach($facility->images as $img)
                                <button wire:click="setMainImage('{{ $img->image_path }}')" class="flex-shrink-0 w-24 h-24 rounded-xl overflow-hidden border-2 {{ $mainImage === $img->image_path ? 'border-[#076f60] ring-2 ring-[#076f60] ring-offset-1' : 'border-transparent opacity-60 hover:opacity-100' }} transition-all duration-200">
                                    <img src="{{ \Illuminate\Support\Str::startsWith($img->image_path, ['http://', 'https://']) ? $img->image_path : asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Header Info -->
                <div class="border-b border-gray-200 pb-8">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 text-xs font-semibold text-[#076f60] bg-[#e6f4f1] border border-[#076f60]/20 rounded-full">
                            {{ $facility->category }}
                        </span>
                        <div class="flex items-center text-sm font-bold text-[#076f60]">
                            <svg class="w-4 h-4 text-[#076f60] mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            4.9 <span class="text-gray-500 font-normal ml-1">(124 Ulasan)</span>
                        </div>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">{{ $facility->name }}</h1>
                    
                    <div class="flex items-start text-gray-600">
                        <svg class="w-5 h-5 mr-2 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <p class="text-base">{{ $facility->address }}</p>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Deskripsi</h2>
                    <div class="prose prose-green max-w-none text-gray-600 leading-relaxed">
                        {!! nl2br(e($facility->description)) !!}
                    </div>
                </div>

                <!-- Info Seller -->
                <div class="border-t border-b border-gray-200 py-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Informasi Toko</h3>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            @php
                                $sellerProfile = $facility->seller->sellerProfile ?? null;
                            @endphp
                            
                            <div class="h-16 w-16 rounded-full bg-[#05574b] overflow-hidden flex items-center justify-center text-white font-bold text-2xl flex-shrink-0 shadow-sm">
                                @if($sellerProfile && $sellerProfile->logo)
                                    <img src="{{ asset('storage/' . $sellerProfile->logo) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($sellerProfile->shop_name ?? $facility->seller->name, 0, 1) }}
                                @endif
                            </div>
                            
                            <div>
                                <p class="text-xl font-bold text-gray-900 leading-tight">
                                    {{ $sellerProfile->shop_name ?? $facility->seller->name }}
                                </p>
                                @if($sellerProfile)
                                    <p class="text-sm text-[#076f60] mt-1 flex items-center gap-1 font-semibold">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <span>Mitra Arena Terverifikasi</span>
                                    </p>
                                @endif
                            </div>
                        </div>

                        @if($sellerProfile)
                            <a href="{{ route('shop.detail', $sellerProfile->shop_slug) }}" class="px-5 py-2.5 text-sm font-bold text-[#076f60] bg-white border-2 border-[#076f60] hover:bg-[#076f60] hover:text-white rounded-xl transition-colors">
                                Kunjungi Toko
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Review Section -->
                <livewire:review-list :facilityId="$facility->id" />

            </div>


            <!-- KOLOM KANAN: Booking Card (Sticky & Fixed Button Area) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    
                    <!-- KUNCI PERUBAHAN: flex-col dan max-h agar layout terkunci ukurannya -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 flex flex-col overflow-hidden max-h-[calc(100vh-7rem)]">
                        
                        <!-- AREA ATAS (Scrollable): Harga, Tanggal, Slot Waktu -->
                        <div class="p-6 overflow-y-auto no-scrollbar flex-1 relative">
                            
                            <!-- Harga Sewa -->
                            <div class="mb-6 border-b border-gray-100 pb-6">
                                <p class="text-sm font-medium text-gray-500 mb-2">Harga mulai dari</p>
                                <div class="flex items-baseline text-gray-900">
                                    <span class="text-3xl font-extrabold">Rp {{ number_format($facility->price_per_hour, 0, ',', '.') }}</span>
                                    <span class="text-sm font-medium text-gray-500 ml-2">/ Jam</span>
                                </div>
                            </div>

                            <!-- Form Booking Livewire -->
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-900 mb-2">Pilih Tanggal</label>
                                <input type="date" wire:model="selectedDate" min="{{ date('Y-m-d') }}" class="block w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#076f60] focus:border-[#076f60] text-gray-700 bg-gray-50 cursor-pointer">
                            </div>

                            <div class="mb-2 relative">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-bold text-gray-900">Pilih Slot Waktu</label>
                                    <div wire:loading wire:target="selectedDate" class="text-xs text-[#076f60] animate-pulse font-medium">Memuat jadwal...</div>
                                </div>

                                @if(empty($availableSlots))
                                    <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200 mb-4">
                                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <p class="text-sm font-medium text-gray-700">Tidak ada jadwal</p>
                                        <p class="text-xs text-gray-500 mt-1">Fasilitas ini tutup pada tanggal yang Anda pilih.</p>
                                    </div>
                                @else
                                    <!-- Menghapus max-h-60 dari sini karena scroll sudah diatur di parent div utama -->
                                    <div class="grid grid-cols-3 gap-2 pr-1 mb-4">
                                        @foreach($availableSlots as $slot)
                                            @if($slot['is_available'])
                                                <button wire:click="selectSlot('{{ $slot['time'] }}')" 
                                                    class="py-2 px-1 text-sm font-bold rounded-lg border transition duration-200 focus:outline-none {{ $selectedSlot === $slot['time'] ? 'bg-[#076f60] text-white border-[#076f60] shadow-md transform scale-105' : 'bg-white text-gray-700 border-gray-300 hover:border-[#076f60] hover:text-[#076f60] hover:bg-[#e6f4f1]' }}">
                                                    {{ $slot['time'] }}
                                                </button>
                                            @else
                                                <button disabled class="py-2 px-1 text-sm font-medium rounded-lg border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed relative group overflow-visible">
                                                    {{ $slot['time'] }}
                                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block w-max bg-gray-900 text-white text-xs rounded px-2 py-1 z-20 shadow-lg">
                                                        {{ $slot['reason'] === 'passed' ? 'Waktu sudah lewat' : 'Sudah dipesan' }}
                                                        <svg class="absolute text-gray-900 h-2 w-full left-0 top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"><polygon class="fill-current" points="0,0 127.5,127.5 255,0"/></svg>
                                                    </div>
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                    
                                    @if($selectedSlot)
                                        <div class="mt-4 p-3 bg-[#e6f4f1] border border-[#076f60]/30 rounded-xl flex items-center mb-4">
                                            <svg class="w-5 h-5 text-[#076f60] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="text-sm text-[#076f60] font-medium">Slot mulai: <strong>{{ $selectedSlot }} WIB</strong></span>
                                        </div>

                                        @if(count($availableDurations) > 0)
                                            <div class="mb-4">
                                                <label class="block text-sm font-bold text-gray-900 mb-2">Durasi Main</label>
                                                <select wire:model="duration" class="block w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#076f60] focus:border-[#076f60] text-gray-700 bg-gray-50 cursor-pointer transition">
                                                    @foreach($availableDurations as $dur)
                                                        <option value="{{ $dur }}">{{ $dur }} Jam</option>
                                                    @endforeach
                                                </select>
                                                
                                                @if(count($availableDurations) < 5)
                                                    <p class="text-xs text-amber-600 mt-2 flex items-start">
                                                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                        Durasi dibatasi otomatis karena jadwal selanjutnya telah dipesan.
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- AREA BAWAH (Fixed): Tombol Pemesanan Terkunci di Bawah -->
                        <div class="p-6 bg-white border-t border-gray-100 shrink-0 shadow-[0_-4px_10px_rgba(0,0,0,0.03)] z-10">
                            
                            @if (session()->has('error'))
                                <div class="mb-4 text-xs text-red-600 bg-red-50 p-3 rounded-lg text-center border border-red-200">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <button wire:click="bookFacility" wire:loading.attr="disabled" class="w-full flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-[#076f60] hover:bg-[#05574b] rounded-xl transition duration-200 shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="bookFacility">Pesan Sekarang</span>
                                <span wire:loading wire:target="bookFacility">Memproses...</span>
                            </button>

                            @auth
                                @if(auth()->user()->role === 'buyer')
                                    <form action="{{ route('chat.start', $facility->id) }}" method="POST" class="w-full mt-3">
                                        @csrf
                                        <button type="submit" class="w-full flex justify-center items-center px-6 py-3 border border-gray-300 text-gray-700 bg-white rounded-xl font-bold hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#076f60]">
                                            <svg class="w-5 h-5 mr-2 text-[#076f60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                            Tanya Penjual
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full mt-3 flex justify-center items-center px-6 py-3 border border-gray-300 text-gray-700 bg-white rounded-xl font-bold hover:bg-gray-50 transition-colors">
                                    <svg class="w-5 h-5 mr-2 text-[#076f60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    Tanya Penjual
                                </a>
                            @endauth

                            <div class="mt-4 text-center text-xs text-gray-500 flex justify-center items-center">
                                <svg class="w-4 h-4 mr-1 text-[#076f60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                Konfirmasi Pemesanan Instan
                            </div>
                        </div>

                    </div>
                </div> 
            </div> 
            
        </div>
    </div>
</div>