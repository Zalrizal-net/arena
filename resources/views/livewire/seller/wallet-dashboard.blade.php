<div>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dompet Saya</h1>
            <p class="text-gray-500 mt-1">Pantau saldo, pendapatan, dan riwayat mutasi Anda.</p>
        </div>
        <a href="{{ route('wallet.withdraw') }}" class="py-2.5 px-6 bg-[#076f60] text-white font-bold rounded-xl shadow-sm hover:bg-[#05574b] transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tarik Dana
        </a>
    </div>

    @if (session()->has('success'))
        <div class="mb-6 bg-green-50 text-green-700 p-4 rounded-xl border border-green-100 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Saldo Bisa Ditarik</p>
            <p class="text-3xl font-black text-[#076f60]">Rp {{ number_format($wallet->available_balance, 0, ',', '.') }}</p>
            <div class="absolute right-0 bottom-0 opacity-5 -mb-4 -mr-4">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Saldo Tertahan</p>
            <p class="text-3xl font-black text-orange-500">Rp {{ number_format($wallet->pending_balance, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-2">Menunggu pelanggan selesai main.</p>
        </div>

        <div class="bg-gray-900 p-6 rounded-2xl shadow-sm">
            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Total Pendapatan</p>
            <p class="text-3xl font-black text-white">Rp {{ number_format($wallet->total_income, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-2">Akumulasi bersih dari awal.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-lg font-bold text-gray-900">Riwayat Mutasi Saldo</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white border-b border-gray-100 text-xs uppercase text-gray-500 font-bold">
                        <th class="p-4 whitespace-nowrap">Tanggal</th>
                        <th class="p-4 whitespace-nowrap">Deskripsi</th>
                        <th class="p-4 whitespace-nowrap">Tipe</th>
                        <th class="p-4 whitespace-nowrap">Status</th>
                        <th class="p-4 whitespace-nowrap text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($transactions as $trx)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-sm text-gray-600">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                            <td class="p-4">
                                <p class="text-sm font-semibold text-gray-900">{{ $trx->description }}</p>
                                @if($trx->booking_id)
                                    <p class="text-xs text-gray-500">Booking ID: {{ $trx->booking->booking_code ?? '-' }}</p>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded uppercase">{{ $trx->type }}</span>
                            </td>
                            <td class="p-4">
                                @if($trx->status === 'completed')
                                    <span class="px-2 py-1 bg-green-50 text-green-600 text-xs font-bold rounded">COMPLETED</span>
                                @elseif($trx->status === 'pending')
                                    <span class="px-2 py-1 bg-yellow-50 text-yellow-600 text-xs font-bold rounded">PENDING</span>
                                @else
                                    <span class="px-2 py-1 bg-red-50 text-red-600 text-xs font-bold rounded">CANCELLED</span>
                                @endif
                            </td>
                            <td class="p-4 text-right font-bold {{ $trx->amount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $trx->amount >= 0 ? '+' : '' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">Belum ada riwayat transaksi dompet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transactions->hasPages())
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>