<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Booking Masuk</h1>
            <p class="text-gray-500 mt-1">Kelola semua pesanan fasilitas olahraga Anda.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Cari Kode Booking..." class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-[#076f60] focus:border-[#076f60] text-sm w-full sm:w-64">
            
            <select wire:model="status" class="px-4 py-2 border border-gray-200 rounded-lg focus:ring-[#076f60] focus:border-[#076f60] text-sm w-full sm:w-48">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="on_going">On Going</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold">
                        <th class="p-4 whitespace-nowrap">Kode Booking</th>
                        <th class="p-4 whitespace-nowrap">Pelanggan</th>
                        <th class="p-4 whitespace-nowrap">Fasilitas</th>
                        <th class="p-4 whitespace-nowrap">Jadwal</th>
                        <th class="p-4 whitespace-nowrap">Status Booking</th>
                        <th class="p-4 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-semibold text-gray-900">{{ $booking->booking_code }}</td>
                            <td class="p-4">
                                <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->user->phone ?? '-' }}</p>
                            </td>
                            <td class="p-4 text-gray-700">{{ $booking->facility->name }}</td>
                            <td class="p-4">
                                <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }} WIB</p>
                            </td>
                            <td class="p-4">
                                @if($booking->status === 'pending')
                                    <span class="px-2 py-1 bg-yellow-50 text-yellow-600 text-xs font-bold rounded-md">PENDING</span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="px-2 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-md">CONFIRMED</span>
                                @elseif($booking->status === 'completed')
                                    <span class="px-2 py-1 bg-green-50 text-green-600 text-xs font-bold rounded-md">COMPLETED</span>
                                @else
                                    <span class="px-2 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-md">CANCELLED</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="text-sm font-bold text-[#076f60] hover:text-[#05574b] transition">
                                    Detail &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                Tidak ada data booking yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($bookings->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>