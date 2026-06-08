<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Pendapatan</h1>
        <p class="text-gray-500 mt-1">Pantau total penghasilan dan saldo pencairan dari fasilitas Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-[#076f60] text-white p-6 rounded-2xl shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-sm font-medium text-emerald-100 mb-1">Total Pendapatan (Kotor)</p>
                <p class="text-3xl font-black">Rp {{ number_format($stats['total_income'], 0, ',', '.') }}</p>
            </div>
            <svg class="absolute right-0 bottom-0 w-32 h-32 text-white opacity-10 -mr-4 -mb-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Saldo Tersedia (Bisa Ditarik)</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['available_balance'], 0, ',', '.') }}</p>
                <p class="text-xs text-green-600 mt-2">Dari booking yang sudah selesai</p>
            </div>
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Saldo Tertahan (Pending)</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['pending_balance'], 0, ',', '.') }}</p>
                <p class="text-xs text-orange-500 mt-2">Menunggu booking selesai</p>
            </div>
            <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Transaksi Dibayar</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_transactions'] }} Transaksi</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Booking Keseluruhan</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_bookings'] }} Booking</p>
            </div>
        </div>
    </div>
</div>