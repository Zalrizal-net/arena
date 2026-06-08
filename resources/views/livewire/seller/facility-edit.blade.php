<div>
    <div class="mb-6 pb-4 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Edit Fasilitas</h1>
        </div>
        <div>
            <a href="{{ route('seller.facilities.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                Batal & Kembali
            </a>
        </div>
    </div>

    <form wire:submit.prevent="update" class="space-y-8">
        
        <div class="bg-white shadow border border-gray-100 rounded-xl overflow-hidden p-6 md:p-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6 border-b pb-4">Informasi Dasar</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1 md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lapangan / Fasilitas</label>
                    <input type="text" wire:model.defer="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm">
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori Olahraga</label>
                    <select id="category" wire:model.defer="category" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm">
                        <option value="">Pilih Kategori...</option>
                        <option value="futsal">Futsal</option>
                        <option value="badminton">Badminton</option>
                        <option value="basket">Basket</option>
                        <option value="tenis">Tenis</option>
                        <option value="renang">Renang</option>
                        <option value="gym">Gym / Fitness</option>
                    </select>
                    @error('category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="price_per_hour" class="block text-sm font-medium text-gray-700">Harga Sewa per Jam (Rp)</label>
                    <input type="number" wire:model.defer="price_per_hour" id="price_per_hour" min="0" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm">
                    @error('price_per_hour') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">Kota / Kabupaten</label>
                    <input type="text" wire:model.defer="city" id="city" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm">
                    @error('city') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status Operasional</label>
                    <select id="status" wire:model.defer="status" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm">
                        <option value="active">Aktif (Tersedia)</option>
                        <option value="inactive">Non-Aktif (Tutup Sementara)</option>
                    </select>
                    @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea id="address" wire:model.defer="address" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm"></textarea>
                    @error('address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-1 md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Fasilitas</label>
                    <textarea id="description" wire:model.defer="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm"></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="bg-white shadow border border-gray-100 rounded-xl overflow-hidden p-6 md:p-8">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6 border-b pb-4">Media & Gambar</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail Utama</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative group hover:border-[#076f60] transition">
                        <div class="space-y-1 text-center">
                            @if ($newThumbnail)
                                <img src="{{ $newThumbnail->temporaryUrl() }}" class="mx-auto h-32 object-cover rounded-md mb-4 border border-[#076f60]">
                                <p class="text-xs text-[#076f60] font-semibold mb-2">Gambar Baru Dipilih</p>
                            @elseif ($oldThumbnail)
                                <img src="{{ asset('storage/' . $oldThumbnail) }}" class="mx-auto h-32 object-cover rounded-md mb-4 opacity-70">
                                <p class="text-xs text-gray-500 mb-2">Gambar Saat Ini</p>
                            @else
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @endif
                            
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="newThumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-[#076f60] hover:text-[#05574b] focus-within:outline-none">
                                    <span>Ganti Gambar</span>
                                    <input id="newThumbnail" wire:model="newThumbnail" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <div wire:loading wire:target="newThumbnail" class="absolute inset-0 bg-white/80 flex items-center justify-center">
                            <span class="text-[#076f60] font-medium text-sm animate-pulse">Mengunggah...</span>
                        </div>
                    </div>
                    @error('newThumbnail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Foto Tambahan</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative group hover:border-[#076f60] transition">
                        <div class="space-y-1 text-center w-full">
                            
                            @if ($newImages)
                                <p class="text-xs text-[#076f60] font-semibold mb-2">Galeri Baru (Akan menggantikan galeri lama)</p>
                                <div class="flex flex-wrap gap-2 justify-center mb-4">
                                    @foreach ($newImages as $image)
                                        <img src="{{ $image->temporaryUrl() }}" class="h-16 w-16 object-cover rounded-md border border-[#076f60]">
                                    @endforeach
                                </div>
                            @elseif (!empty($oldImages))
                                <p class="text-xs text-gray-500 mb-2">Galeri Saat Ini</p>
                                <div class="flex flex-wrap gap-2 justify-center mb-4">
                                    @foreach ($oldImages as $oldImg)
                                        <img src="{{ asset('storage/' . $oldImg) }}" class="h-16 w-16 object-cover rounded-md opacity-70 border border-gray-200">
                                    @endforeach
                                </div>
                            @endif

                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="newImages" class="relative cursor-pointer bg-white rounded-md font-medium text-[#076f60] hover:text-[#05574b] focus-within:outline-none">
                                    <span>Ganti Semua Galeri</span>
                                    <input id="newImages" wire:model="newImages" type="file" multiple class="sr-only" accept="image/*">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Mengunggah file baru akan menghapus seluruh galeri lama.</p>
                        </div>
                        <div wire:loading wire:target="newImages" class="absolute inset-0 bg-white/80 flex items-center justify-center">
                            <span class="text-[#076f60] font-medium text-sm animate-pulse">Memproses gambar...</span>
                        </div>
                    </div>
                    @error('newImages.*') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#076f60] hover:bg-[#05574b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#076f60] disabled:opacity-70 disabled:cursor-not-allowed transition">
                <span wire:loading.remove wire:target="update">Simpan Perubahan</span>
                <span wire:loading wire:target="update">Menyimpan...</span>
            </button>
        </div>
    </form>
</div>