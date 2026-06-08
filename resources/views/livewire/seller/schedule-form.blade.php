<div>
    <div class="mb-6 pb-4 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{ $scheduleId ? 'Edit Jadwal' : 'Tambah Jadwal Baru' }}
            </h1>
            <p class="mt-1 text-sm text-gray-500">Fasilitas: <span class="font-semibold text-[#076f60]">{{ $facilityName }}</span></p>
        </div>
        <div>
            <a href="{{ route('seller.schedules.index', $facilityId) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                Batal & Kembali
            </a>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="mb-6 p-4 text-sm text-red-700 bg-red-50 rounded-xl border border-red-200 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2">
            <form wire:submit.prevent="save" class="bg-white shadow border border-gray-100 rounded-xl overflow-hidden p-6 md:p-8 space-y-6">
                
                <h3 class="text-lg font-medium leading-6 text-gray-900 border-b pb-4">Pengaturan Waktu Operasional</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="day_of_week" class="block text-sm font-medium text-gray-700">Hari Operasional</label>
                        <select id="day_of_week" wire:model.defer="day_of_week" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm">
                            <option value="">-- Pilih Hari --</option>
                            <option value="1">Senin</option>
                            <option value="2">Selasa</option>
                            <option value="3">Rabu</option>
                            <option value="4">Kamis</option>
                            <option value="5">Jumat</option>
                            <option value="6">Sabtu</option>
                            <option value="7">Minggu</option>
                        </select>
                        @error('day_of_week') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="open_time" class="block text-sm font-medium text-gray-700">Jam Buka</label>
                        <input type="time" wire:model.debounce.500ms="open_time" id="open_time" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm">
                        @error('open_time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="close_time" class="block text-sm font-medium text-gray-700">Jam Tutup</label>
                        <input type="time" wire:model.debounce.500ms="close_time" id="close_time" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm">
                        @error('close_time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="slot_duration" class="block text-sm font-medium text-gray-700">Durasi per Slot (Menit)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" wire:model.debounce.500ms="slot_duration" id="slot_duration" min="30" step="5" class="block w-full border border-gray-300 rounded-md pl-3 pr-12 py-2 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm" placeholder="60">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Menit</span>
                            </div>
                        </div>
                        @error('slot_duration') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700">Status Aktif</label>
                        <select id="is_active" wire:model.defer="is_active" class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm">
                            <option value="1">Buka / Tersedia</option>
                            <option value="0">Tutup Sementara</option>
                        </select>
                        @error('is_active') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" wire:loading.attr="disabled" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#076f60] hover:bg-[#05574b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#076f60] disabled:opacity-70 disabled:cursor-not-allowed transition">
                        <span wire:loading.remove wire:target="save">Simpan Jadwal</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-hidden sticky top-24">
                <div class="p-4 bg-gray-900 border-b border-gray-700 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-white flex items-center">
                        <svg class="w-4 h-4 mr-2 text-[#076f60]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pratinjau Slot Tersedia
                    </h3>
                    <div wire:loading wire:target="open_time, close_time, slot_duration" class="text-xs text-gray-400 animate-pulse">
                        Menghitung...
                    </div>
                </div>
                
                <div class="p-6">
                    @if(empty($previewSlots))
                        <div class="text-center py-8">
                            <svg class="mx-auto h-10 w-10 text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <p class="text-sm text-gray-400">Silakan masukkan kombinasi Jam Buka, Jam Tutup, dan Durasi yang valid untuk melihat daftar slot.</p>
                        </div>
                    @else
                        <div class="mb-4 text-xs text-gray-400 text-center uppercase tracking-wider font-semibold border-b border-gray-700 pb-2">
                            Total: <span class="text-[#076f60]">{{ count($previewSlots) }} Slot</span>
                        </div>
                        <div class="grid grid-cols-3 gap-3 max-h-96 overflow-y-auto no-scrollbar pb-2">
                            @foreach($previewSlots as $slot)
                                <div class="bg-gray-700 border border-gray-600 rounded-lg py-2 text-center text-sm font-medium text-white shadow-sm hover:bg-gray-600 transition cursor-default">
                                    {{ $slot }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>