<div>
    <div class="mb-6 pb-4 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Jadwal Operasional</h1>
            <p class="mt-1 text-sm text-gray-500">Fasilitas: <span class="font-semibold text-[#076f60]">{{ $facilityName }}</span></p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('seller.facilities.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                Kembali
            </a>
            <a href="{{ route('seller.schedules.create', $facilityId) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#076f60] hover:bg-[#05574b] transition">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jadwal
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 text-sm text-green-700 bg-green-50 rounded-xl border border-green-200 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 text-sm text-red-700 bg-red-50 rounded-xl border border-red-200 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow border border-gray-100 rounded-xl overflow-hidden relative">
        
        <div wire:loading.flex wire:target="deleteSchedule, toggleStatus" class="absolute inset-0 bg-white/60 z-10 items-center justify-center backdrop-blur-sm">
            <div class="flex items-center text-[#076f60] font-semibold">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Memproses...
            </div>
        </div>

        @if($schedules->isEmpty())
            <div class="text-center py-16 px-4">
                <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="text-sm font-medium text-gray-900">Belum ada jadwal</h3>
                <p class="mt-1 text-sm text-gray-500">Anda belum menentukan jam buka/tutup untuk fasilitas ini.</p>
                <div class="mt-6">
                    <a href="{{ route('seller.schedules.create', $facilityId) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#076f60] hover:bg-[#05574b] transition">
                        Buat Jadwal Pertama
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Hari</th>
                            <th scope="col" class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam Operasional</th>
                            <th scope="col" class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Durasi Slot</th>
                            <th scope="col" class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Total Slot</th>
                            <th scope="col" class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                            <th scope="col" class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($schedules as $schedule)
                            @php
                                $slotsCount = count(app(\App\Services\ScheduleService::class)->generateSlots($schedule->open_time, $schedule->close_time, $schedule->slot_duration));
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-100">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $this->getDayName($schedule->day_of_week) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ substr($schedule->open_time, 0, 5) }} - {{ substr($schedule->close_time, 0, 5) }} WIB
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded-md">{{ $schedule->slot_duration }} Menit</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm font-bold text-[#076f60]">{{ $slotsCount }} Slot</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button wire:click="toggleStatus({{ $schedule->id }})" class="focus:outline-none transition-transform hover:scale-105">
                                        @if($schedule->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-gray-700 border border-gray-200">
                                                Tutup
                                            </span>
                                        @endif
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                    <a href="{{ route('seller.schedules.edit', ['facilityId' => $facilityId, 'scheduleId' => $schedule->id]) }}" class="text-[#076f60] hover:text-[#05574b] font-semibold transition">Ubah</a>
                                    
                                    <button onclick="confirm('Apakah Anda yakin ingin menghapus jadwal ini?') || event.stopImmediatePropagation()" 
                                            wire:click="deleteSchedule({{ $schedule->id }})" 
                                            class="text-red-600 hover:text-red-900 font-semibold transition">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-white">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>
</div>