<div class="mt-12 pt-10 border-t border-gray-200">
    <h2 class="text-2xl font-bold text-gray-900 mb-8">Ulasan & Penilaian</h2>

    <div class="flex items-center gap-6 mb-10 bg-gray-50 p-6 rounded-2xl border border-gray-100">
        <div class="text-center">
            <p class="text-5xl font-black text-gray-900">{{ number_format($facility->average_rating, 1) }}</p>
            <div class="flex items-center justify-center mt-2 text-yellow-400">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= round($facility->average_rating) ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <p class="text-sm text-gray-500 mt-1">Berdasarkan {{ $facility->total_reviews }} ulasan</p>
        </div>
    </div>

    <div class="space-y-8">
        @forelse ($reviews as $review)
            <div class="border-b border-gray-100 pb-8">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-[#076f60] rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $review->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $review->created_at->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
                
                <p class="mt-4 text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                
                @if($review->images->count() > 0)
                    <div class="mt-4 flex gap-3 overflow-x-auto pb-2">
                        @foreach($review->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Foto ulasan" class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-10 bg-gray-50 rounded-2xl border border-gray-100">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <h3 class="text-lg font-bold text-gray-900">Belum ada ulasan</h3>
                <p class="text-gray-500 text-sm mt-1">Jadilah yang pertama memberikan ulasan setelah bermain di sini!</p>
            </div>
        @endforelse

        @if($reviews->hasPages())
            <div class="mt-6">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>