<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Pesanan Saya</h1>
        <p class="text-gray-500 mt-1">Daftar riwayat penyewaan dan status pembayaran Anda.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="divide-y divide-gray-100">
            @forelse ($bookings as $booking)
                <div class="p-6 hover:bg-gray-50 transition flex flex-col md:flex-row justify-between md:items-center gap-6">
                    
                    <!-- Bagian Kiri: Info Fasilitas -->
                    <div class="flex items-center gap-5 flex-1">
                        <div class="w-20 h-20 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0">
                            <img src="{{ \Illuminate\Support\Str::startsWith($booking->facility->thumbnail, ['http://', 'https://']) ? $booking->facility->thumbnail : asset('storage/' . $booking->facility->thumbnail) }}" alt="{{ $booking->facility->name }}" class="w-full h-full object-cover">
                            {{-- <img src="{{ asset('storage/' . $booking->facility->thumbnail) }}" alt="{{ $booking->facility->name }}" class="w-full h-full object-cover"> --}}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 mb-1">ID: {{ $booking->booking_code }}</p>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $booking->facility->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                <svg class="w-4 h-4 inline-block mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                                <span class="mx-2">•</span>
                                <svg class="w-4 h-4 inline-block mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }} WIB
                            </p>
                        </div>
                    </div>
                    
                    <!-- Bagian Kanan: Harga, Status, dan Tombol Ulasan -->
                    <div class="flex flex-col md:items-end gap-3 flex-shrink-0">
                        <p class="font-extrabold text-[#076f60] text-xl">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        
                        <!-- Label Status -->
                        <div class="flex flex-wrap gap-2 md:justify-end">
                            @if($booking->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-50 text-yellow-600 text-xs font-bold rounded-lg border border-yellow-100">BOOKING: PENDING</span>
                            @elseif($booking->status === 'confirmed')
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg border border-blue-100">BOOKING: CONFIRMED</span>
                            @elseif($booking->status === 'completed')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-lg border border-emerald-100">SELESAI</span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-lg border border-red-100">BATAL</span>
                            @endif

                            @if($booking->payment_status === 'unpaid')
                                <span class="px-3 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-lg border border-red-100">PAYMENT: UNPAID</span>
                            @elseif($booking->payment_status === 'refund_pending')
                                <span class="px-3 py-1 bg-orange-50 text-orange-600 text-xs font-bold rounded-lg border border-orange-100">REFUND PENDING</span>
                            @else
                                <span class="px-3 py-1 bg-green-50 text-green-600 text-xs font-bold rounded-lg border border-green-100">PAYMENT: PAID</span>
                            @endif
                        </div>

                        <!-- TOMBOL ULASAN (Sekarang ada di dalam loop, tepat di bawah status) -->
                        @if($booking->status === 'completed' && $booking->payment_status === 'paid')
                            @if(!$booking->review)
                                <a href="{{ route('buyer.review.create', $booking->id) }}" class="mt-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-yellow-400 text-yellow-900 text-sm font-bold rounded-lg shadow-sm hover:bg-yellow-500 transition w-full md:w-auto">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Beri Ulasan
                                </a>
                            @else
                                <span class="mt-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-50 text-gray-500 text-sm font-bold rounded-lg border border-gray-200 w-full md:w-auto">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Sudah Diulas
                                </span>
                            @endif
                        @endif

                    </div>

                </div>
            @empty
                <div class="p-16 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Riwayat Kosong</h3>
                    <p class="text-gray-500">Anda belum pernah melakukan pemesanan fasilitas olahraga.</p>
                </div>
            @endforelse
        </div>
        
        @if($bookings->hasPages())
            <div class="p-6 border-t border-gray-100 bg-gray-50/50">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>