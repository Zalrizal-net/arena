<div class="max-w-3xl mx-auto py-8">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('buyer.dashboard') }}" class="p-2 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tulis Ulasan</h1>
            <p class="text-gray-500 mt-1">Bagaimana pengalaman Anda di <span class="font-bold text-[#076f60]">{{ $facility_name }}</span>?</p>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-xl border border-red-100 font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
        <form wire:submit.prevent="submitReview" class="space-y-8">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-3">Beri Nilai (Bintang)</label>
                <div class="flex items-center gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none transition-transform hover:scale-110">
                            <svg class="w-12 h-12 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-200' }} transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </button>
                    @endfor
                </div>
                @error('rating') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Ceritakan Pengalaman Anda</label>
                <textarea wire:model.defer="comment" rows="5" class="w-full px-4 py-3 rounded-xl border focus:ring-[#076f60] focus:border-[#076f60] bg-gray-50 focus:bg-white transition" placeholder="Contoh: Lapangannya sangat bersih, fasilitas toilet dan ruang ganti nyaman. Pasti bakal sewa di sini lagi!"></textarea>
                <p class="text-xs text-gray-500 mt-2">Minimal 10 karakter.</p>
                @error('comment') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tambahkan Foto (Opsional)</label>
                
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-[#076f60] hover:text-[#05574b] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#076f60]">
                                <span>Pilih file foto</span>
                                <input type="file" wire:model="images" multiple accept="image/png, image/jpeg, image/jpg" class="sr-only">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG up to 2MB (Maksimal 5 foto)</p>
                    </div>
                </div>
                @error('images.*') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                @error('images') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror

                @if ($images)
                    <div class="mt-4 flex gap-4 overflow-x-auto pb-2">
                        @foreach ($images as $image)
                            <div class="relative w-24 h-24 rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-full">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="pt-4 border-t border-gray-100">
                <button type="submit" wire:loading.attr="disabled" class="w-full py-4 px-6 bg-[#076f60] text-white font-bold rounded-xl shadow-md hover:bg-[#05574b] transition flex items-center justify-center gap-2 text-lg">
                    <span wire:loading.remove wire:target="submitReview">Kirim Ulasan</span>
                    <span wire:loading wire:target="submitReview">Mengirim...</span>
                </button>
            </div>
            
        </form>
    </div>
</div>