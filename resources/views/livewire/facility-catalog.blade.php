<div>
    <div class="relative pt-16 pb-6">
        <div class="absolute inset-0 bg-gradient-to-b from-[#cff0e9]/80 via-[#e8f7f5]/60 to-white -z-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-1xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 text-center mb-6 tracking-tight">
                Temukan Arena Terbaik untuk Performa Maksimal Anda.
            </h3>
        </div>
    </div>

    <div class="sticky top-16 z-20 bg-white/80 backdrop-blur-md border-b border-gray-100 py-4 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="max-w-4xl mx-auto bg-white p-2 rounded-2xl shadow-sm border border-gray-200 flex flex-col md:flex-row gap-2">
                
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.debounce.300ms="search" type="text" placeholder="Cari Fasilitas..." 
                           class="w-full pl-11 pr-4 py-3 bg-white border border-transparent rounded-xl focus:ring-2 focus:ring-[#076f60] focus:border-transparent text-sm md:text-base transition-shadow outline-none">
                </div>

                <div class="w-full md:w-64 shrink-0 relative border-t md:border-t-0 md:border-l border-gray-100">
                    <select wire:model="city" class="w-full py-3 pl-4 pr-10 bg-white border border-transparent rounded-xl focus:ring-2 focus:ring-[#076f60] focus:border-transparent text-sm md:text-base transition-shadow appearance-none outline-none cursor-pointer text-gray-700">
                        <option value="">Semua Kota</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                        <option value="Semarang">Semarang</option>
                        <option value="Medan">Medan</option>
                        <option value="Bali">Bali</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- <div class="max-w-4xl mx-auto mt-4 flex flex-wrap justify-center md:justify-start gap-2 sm:gap-3">
                <button wire:click="$set('category', '')" class="{{ ($category ?? '') === '' ? 'bg-[#076f60] text-white border-transparent shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-[#076f60] hover:text-[#076f60]' }} px-4 sm:px-6 py-2 rounded-full border text-xs sm:text-sm font-semibold transition-all duration-200">
                    Semua
                </button>
                <button wire:click="$set('category', 'Futsal')" class="{{ ($category ?? '') === 'Futsal' ? 'bg-[#076f60] text-white border-transparent shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-[#076f60] hover:text-[#076f60]' }} px-4 sm:px-6 py-2 rounded-full border text-xs sm:text-sm font-semibold transition-all duration-200">
                    Futsal
                </button>
                <button wire:click="$set('category', 'Badminton')" class="{{ ($category ?? '') === 'Badminton' ? 'bg-[#076f60] text-white border-transparent shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-[#076f60] hover:text-[#076f60]' }} px-4 sm:px-6 py-2 rounded-full border text-xs sm:text-sm font-semibold transition-all duration-200">
                    Badminton
                </button>
                <button wire:click="$set('category', 'Basket')" class="{{ ($category ?? '') === 'Basket' ? 'bg-[#076f60] text-white border-transparent shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-[#076f60] hover:text-[#076f60]' }} px-4 sm:px-6 py-2 rounded-full border text-xs sm:text-sm font-semibold transition-all duration-200">
                    Basket
                </button>
                <button wire:click="$set('category', 'Renang')" class="{{ ($category ?? '') === 'Renang' ? 'bg-[#076f60] text-white border-transparent shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-[#076f60] hover:text-[#076f60]' }} px-4 sm:px-6 py-2 rounded-full border text-xs sm:text-sm font-semibold transition-all duration-200">
                    Renang
                </button>
                <button wire:click="$set('category', 'Tenis')" class="{{ ($category ?? '') === 'Tenis' ? 'bg-[#076f60] text-white border-transparent shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-[#076f60] hover:text-[#076f60]' }} px-4 sm:px-6 py-2 rounded-full border text-xs sm:text-sm font-semibold transition-all duration-200">
                    Tenis
                </button>
            </div> --}}

        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if($facilities->isEmpty())
            <div class="text-center py-20 border border-dashed border-gray-300 rounded-2xl bg-gray-50 shadow-sm mt-4">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-lg font-medium text-gray-900">Tidak ada fasilitas ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Coba sesuaikan kata kunci pencarian atau filter kota dan kategori Anda.</p>
                <button wire:click="$set('search', ''); $set('city', ''); $set('category', '');" class="mt-4 text-[#076f60] font-medium hover:text-[#05574b] hover:underline">
                    Reset Filter
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-4">
                @foreach($facilities as $facility)
                    <x-card-katalog 
                        :title="$facility->name"
                        :subtitle="$facility->city"
                        :price="$facility->price_per_hour"
                        :image="$facility->thumbnail"
                        :rating="4.9"
                        :link="route('facility.show', $facility->slug)"
                        type="fasilitas"
                    />
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $facilities->links() }}
            </div>
        @endif
    </div>
</div>