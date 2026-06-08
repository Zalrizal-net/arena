<div class="bg-gray-50 min-h-screen pb-12">
    
    <div class="bg-white border-b border-gray-200">
        <div class="h-48 md:h-64 w-full bg-gray-200 relative overflow-hidden">
            @if($shop->banner)
                <img src="{{ asset('storage/' . $shop->banner) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-[#076f60] to-[#05574b] opacity-90"></div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative pb-8">
            <div class="flex flex-col md:flex-row items-center md:items-end md:-mt-12 gap-6">
                
                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white bg-white shadow-md overflow-hidden relative -mt-12 md:mt-0 z-10 flex-shrink-0">
                    @if($shop->logo)
                        <img src="{{ asset('storage/' . $shop->logo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-[#e6f4f1] text-[#076f60] flex items-center justify-center font-black text-4xl">
                            {{ substr($shop->shop_name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1 text-center md:text-left z-10 mt-4 md:mt-0">
                    <h1 class="text-3xl font-extrabold text-gray-900">{{ $shop->shop_name }}</h1>
                    <p class="text-gray-500 mt-1 flex items-center justify-center md:justify-start gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $shop->city ?? 'Lokasi tidak diatur' }}
                        <span class="mx-2">•</span>
                        Bergabung sejak {{ $shop->created_at->translatedFormat('F Y') }}
                    </p>
                </div>

                <div class="flex items-center gap-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100 z-10">
                    <div class="text-center px-2">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Rating</p>
                        <p class="text-xl font-black text-gray-900 flex items-center justify-center gap-1">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            {{ number_format($stats['average_rating'], 1) }}
                        </p>
                        <p class="text-[10px] text-gray-500 mt-1">({{ $stats['total_reviews'] }} Ulasan)</p>
                    </div>
                    <div class="w-px h-10 bg-gray-200"></div>
                    <div class="text-center px-2">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Fasilitas</p>
                        <p class="text-xl font-black text-[#076f60]">{{ $stats['total_facilities'] }}</p>
                        <p class="text-[10px] text-gray-500 mt-1">Tersedia</p>
                    </div>
                </div>

            </div>

            @if($shop->description)
                <div class="mt-8 max-w-3xl text-gray-600 text-sm leading-relaxed text-center md:text-left">
                    {!! nl2br(e($shop->description)) !!}
                </div>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <h2 class="text-2xl font-extrabold text-gray-900">Katalog Lapangan</h2>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" wire:model.debounce.500ms="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl leading-5 bg-white text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm transition" placeholder="Cari lapangan...">
                </div>

                <select wire:model="sort" class="block w-full sm:w-48 border border-gray-300 rounded-xl px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#076f60] focus:border-[#076f60] text-sm text-gray-700">
                    <option value="newest">Terbaru</option>
                    <option value="lowest_price">Harga Terendah</option>
                    <option value="highest_price">Harga Tertinggi</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($facilities as $fac)
                
                <x-card-katalog 
                    :image="$fac->thumbnail ? asset('storage/' . $fac->thumbnail) : null"
                    :title="$fac->name"
                    :subtitle="$fac->city ?? 'Lokasi tidak diatur'"
                    :price="$fac->price_per_hour"
                    :rating="$fac->average_rating"
                    :link="route('facility.show', $fac->slug)" 
                    :type="$fac->category"
                />
                @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-gray-100">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak Ada Lapangan</h3>
                    <p class="text-gray-500 text-sm">Toko ini belum memiliki fasilitas yang cocok dengan pencarian Anda.</p>
                </div>
            @endforelse
        </div>

        @if($facilities->hasPages())
            <div class="mt-8">
                {{ $facilities->links() }}
            </div>
        @endif
        
    </div>
</div>