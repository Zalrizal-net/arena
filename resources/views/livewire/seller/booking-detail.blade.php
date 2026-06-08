<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('bookings.index') }}" class="p-2 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Detail Booking</h1>
        </div>
        <span class="text-sm font-semibold text-gray-500">ID: {{ $booking->booking_code }}</span>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Fasilitas & Jadwal</h3>
                <div class="flex gap-4 items-start">
                    <img src="{{ asset('storage/' . $booking->facility->thumbnail) }}" alt="{{ $booking->facility->name }}" class="w-24 h-24 rounded-lg object-cover bg-gray-100">
                    <div class="space-y-2">
                        <p class="font-bold text-xl text-gray-900">{{ $booking->facility->name }}</p>
                        <p class="text-sm text-gray-600"><span class="font-semibold">Tanggal:</span> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</p>
                        <p class="text-sm text-gray-600"><span class="font-semibold">Waktu:</span> {{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }} WIB</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Pelanggan</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Nama Lengkap</p>
                        <p class="font-medium text-gray-900">{{ $booking->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">Email</p>
                        <p class="font-medium text-gray-900">{{ $booking->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase">No. Handphone</p>
                        <p class="font-medium text-gray-900">{{ $booking->user->phone ?? 'Tidak dicantumkan' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Status & Pembayaran</h3>
                
                <div class="mb-4">
                    <p class="text-xs text-gray-500 font-bold uppercase mb-1">Status Pembayaran</p>
                    @if($booking->payment_status === 'paid')
                        <span class="px-3 py-1 bg-green-50 text-green-600 text-sm font-bold rounded-md">SUDAH DIBAYAR</span>
                    @else
                        <span class="px-3 py-1 bg-red-50 text-red-600 text-sm font-bold rounded-md">BELUM DIBAYAR</span>
                    @endif
                </div>

                <div class="mb-6">
                    <p class="text-xs text-gray-500 font-bold uppercase mb-1">Status Booking</p>
                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-bold rounded-md uppercase">{{ $booking->status }}</span>
                </div>

                <div class="mb-6">
                    <p class="text-xs text-gray-500 font-bold uppercase mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-black text-[#076f60]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>

                <div class="border-t border-gray-100 pt-4 space-y-2">
                    @if($booking->status === 'pending')
                        <button wire:click="updateStatus('confirmed')" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition">Konfirmasi Booking</button>
                        <button wire:click="updateStatus('cancelled')" class="w-full py-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold rounded-lg transition">Batalkan</button>
                    @elseif($booking->status === 'confirmed')
                        <button wire:click="updateStatus('on_going')" class="w-full py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg transition">Mulai (On Going)</button>
                    @elseif($booking->status === 'on_going')
                        <button wire:click="updateStatus('completed')" class="w-full py-2 bg-[#076f60] hover:bg-[#05574b] text-white font-bold rounded-lg transition">Tandai Selesai</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>