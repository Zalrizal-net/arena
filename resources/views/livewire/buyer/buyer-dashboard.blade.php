<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Ringkasan Dasbor</h1>
        <p class="text-gray-500 mt-1">Pantau aktivitas penyewaan fasilitas olahraga Anda di sini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalBookings }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Menunggu Pembayaran</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingPayments }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Selesai Bermain</p>
                <p class="text-2xl font-bold text-gray-900">{{ $completedBookings }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h2>
            <a href="{{ route('booking.history') ?? '#' }}" class="text-sm font-semibold text-[#076f60] hover:text-[#05574b] transition">Lihat Semua &rarr;</a>
        </div>
        
        <div class="divide-y divide-gray-100">
            @forelse ($recentBookings as $booking)
                <div class="p-6 hover:bg-gray-50 transition flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                            <img src="{{ asset('storage/' . $booking->facility->thumbnail) }}" alt="{{ $booking->facility->name }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $booking->facility->name }}</p>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }} • {{ substr($booking->start_time, 0, 5) }} WIB</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:items-end gap-2">
                        <p class="font-bold text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        <div class="flex gap-2">
                            @if($booking->payment_status === 'unpaid')
                                <span class="px-3 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-full">UNPAID</span>
                            @else
                                <span class="px-3 py-1 bg-green-50 text-green-600 text-xs font-bold rounded-full">PAID</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada pesanan</h3>
                    <p class="text-gray-500 mb-4">Anda belum melakukan penyewaan fasilitas olahraga.</p>
                    <a href="#" class="inline-flex py-2.5 px-6 bg-[#076f60] text-white font-bold rounded-xl shadow-sm hover:bg-[#05574b] transition">Cari Lapangan</a>
                </div>
            @endforelse
        </div>
    </div>
</div>