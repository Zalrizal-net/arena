<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('booking.history') }}" class="text-gray-400 hover:text-[#076f60] transition bg-white p-2 rounded-full shadow-sm border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
        </div>

        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-100 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 md:p-8 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Kode Pesanan</p>
                    <p class="text-xl font-extrabold text-gray-900 uppercase tracking-wide">{{ $booking->booking_code }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-blue-100 text-blue-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $paymentClasses = [
                            'unpaid' => 'bg-red-100 text-red-800',
                            'paid' => 'bg-green-100 text-green-800',
                        ];
                    @endphp
                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase {{ $statusClasses[$booking->status] }}">
                        Status: {{ $booking->status }}
                    </span>
                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase {{ $paymentClasses[$booking->payment_status] }}">
                        Pembayaran: {{ $booking->payment_status }}
                    </span>
                </div>
            </div>

            <div class="p-6 md:p-8 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Informasi Fasilitas</h3>
                <div class="flex items-center gap-4">
                    <div class="h-24 w-24 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100 border border-gray-200">
                        <img src="{{ \Illuminate\Support\Str::startsWith($booking->facility->thumbnail, ['http://', 'https://']) ? $booking->facility->thumbnail : asset('storage/' . $booking->facility->thumbnail) }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <a href="{{ route('facilities.show', $booking->facility->slug) }}" class="text-lg font-bold text-[#076f60] hover:underline">
                            {{ $booking->facility->name }}
                        </a>
                        <p class="text-sm text-gray-500 mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $booking->facility->address }}, {{ $booking->facility->city }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Jadwal Main</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                        <p class="text-sm font-bold text-gray-900">{{ $booking->booking_date->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Jam Mulai</p>
                        <p class="text-sm font-bold text-gray-900">{{ substr($booking->start_time, 0, 5) }} WIB</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Jam Selesai</p>
                        <p class="text-sm font-bold text-gray-900">{{ substr($booking->end_time, 0, 5) }} WIB</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Durasi</p>
                        <p class="text-sm font-bold text-gray-900">{{ $booking->duration }} Menit</p>
                    </div>
                </div>
            </div>

            @if($booking->notes)
            <div class="p-6 md:p-8 border-b border-gray-100 bg-[#f9fafb]">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Catatan Pesanan</h3>
                <p class="text-sm text-gray-700 italic">{{ $booking->notes }}</p>
            </div>
            @endif

            <div class="p-6 md:p-8 bg-gray-50">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Total Tagihan</h3>
                    <p class="text-2xl font-extrabold text-[#076f60]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 mt-6">
                    @if($booking->status === 'pending' && $booking->payment_status === 'unpaid')
                        @if($booking->payment && $booking->payment->snap_token)
                            <button onclick="payWithMidtrans('{{ $booking->payment->snap_token }}')" class="flex-1 py-3 px-4 bg-[#076f60] text-white font-bold rounded-xl shadow-md hover:bg-[#05574b] transition flex justify-center items-center">
                                Bayar Sekarang
                            </button>
                        @endif
                        
                        <button wire:click="cancelBooking" 
                                onclick="confirm('Apakah Anda yakin ingin membatalkan pesanan ini?') || event.stopImmediatePropagation()"
                                wire:loading.attr="disabled"
                                class="py-3 px-6 bg-white border border-red-200 text-red-600 font-bold rounded-xl shadow-sm hover:bg-red-50 hover:border-red-300 transition flex justify-center items-center">
                            <span wire:loading.remove wire:target="cancelBooking">Batalkan Pesanan</span>
                            <span wire:loading wire:target="cancelBooking">Memproses...</span>
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <script>
        function payWithMidtrans(snapToken) {
            window.snap.pay(snapToken, {
                onSuccess: function(result){
                    window.location.reload();
                },
                onPending: function(result){
                    window.location.reload();
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                    window.location.reload();
                },
                onClose: function(){
                    // User menutup popup
                }
            });
        }
    </script>
</div>