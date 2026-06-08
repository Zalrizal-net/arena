@props([
    'image' => null, 
    'title', 
    'subtitle', 
    'price', 
    'rating' => null, 
    'link' => '#',
    'type' => 'fasilitas'
])

<a href="{{ $link }}" class="bg-white rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 active:scale-[0.98] active:shadow-sm active:translate-y-0 transition-all duration-200 border border-gray-100 overflow-hidden flex flex-col h-full group outline-none focus:ring-2 focus:ring-[#076f60] focus:ring-offset-2 block cursor-pointer">
    
    <div class="relative h-48 bg-gray-200 overflow-hidden">
        @if($image)
            <img src="{{ \Illuminate\Support\Str::startsWith($image, ['http://', 'https://']) ? $image : asset('storage/' . $image) }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 00-2-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif

        @if($rating)
            <div class="absolute top-3 right-3 bg-white px-2 py-1 rounded-md shadow text-xs font-bold flex items-center text-gray-800">
                <svg class="w-3 h-3 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                {{ number_format($rating, 1) }}
            </div>
        @endif
    </div>

    <div class="p-5 flex flex-col flex-grow">
        <p class="text-xs font-medium text-[#076f60] mb-1 truncate">
            @if($type === 'fasilitas')
                <svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            @endif
            {{ $subtitle }}
        </p>
        
        <h3 class="text-lg font-bold text-gray-900 mb-4 line-clamp-2">{{ $title }}</h3>
        
        <div class="mt-auto flex items-end justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Mulai dari</p>
                <p class="text-sm font-bold text-gray-900">Rp {{ number_format($price, 0, ',', '.') }} <span class="text-xs font-normal text-gray-500">{{ $type === 'fasilitas' ? '/jam' : '' }}</span></p>
            </div>
            
            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#e6f4f1] text-[#076f60] group-hover:bg-[#076f60] group-hover:text-white transition-colors duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </div>
    </div>
</a>