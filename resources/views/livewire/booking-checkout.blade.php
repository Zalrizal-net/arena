<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Checkout Pesanan</h1>

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6 md:p-8 border-b border-gray-100 flex items-center gap-6">
                <div class="h-24 w-24 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                    <img src="{{ asset('storage/' . $facility->thumbnail) }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $facility->name }}</h2>
                    <p class="text-gray-500 text-sm mt-1">{{ $facility->address }}</p>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-gray-50 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Tanggal Main</p>
                    <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($bookingData['booking_date'])->translatedFormat('l, d F Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Jam Main</p>
                    <p class="font-bold text-gray-900">{{ substr($bookingData['start_time'], 0, 5) }} WIB</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-500 mb-2">Catatan untuk pengelola (Opsional)</label>
                    <textarea wire:model.defer="notes" rows="3" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-[#076f60] focus:border-[#076f60]"></textarea>
                </div>
            </div>

            <div class="p-6 md:p-8 border-t border-gray-100 bg-white">
                <div class="mb-6 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Durasi Bermain</span>
                        <span class="font-bold text-gray-900">{{ $duration }} Jam</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Harga per Jam</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($facility->price_per_hour, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-between items-center pt-6 border-t border-gray-100 gap-4">
                    <div class="w-full md:w-auto text-left md:text-left text-center">
                        <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
                        <p class="text-2xl font-extrabold text-[#076f60]">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                    </div>
                    <button wire:click="confirmBooking" wire:loading.attr="disabled" class="w-full md:w-auto py-3 px-8 bg-[#076f60] text-white font-bold rounded-xl shadow-md hover:bg-[#05574b] transition flex items-center justify-center">
                        <span wire:loading.remove wire:target="confirmBooking">Konfirmasi & Bayar</span>
                        <span wire:loading wire:target="confirmBooking">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <script>
        window.addEventListener('trigger-snap', event => {
            window.snap.pay(event.detail.snapToken, {
                onSuccess: function(result){
                    window.location.href = "{{ route('booking.history') }}";
                },
                onPending: function(result){
                    window.location.href = "{{ route('booking.history') }}";
                },
                onError: function(result){
                    window.location.href = "{{ route('booking.history') }}";
                },
                onClose: function(){
                    window.location.href = "{{ route('booking.history') }}";
                }
            });
        });
    </script>
</div>