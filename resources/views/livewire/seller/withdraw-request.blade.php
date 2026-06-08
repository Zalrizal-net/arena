<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('wallet.index') }}" class="p-2 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Tarik Dana (Withdraw)</h1>
    </div>

    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-xl border border-red-100 font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-blue-50 border border-blue-100 p-6 rounded-2xl mb-8 flex justify-between items-center">
        <div>
            <p class="text-sm font-semibold text-blue-600 uppercase mb-1">Saldo Tersedia</p>
            <p class="text-2xl font-black text-gray-900">Rp {{ number_format($wallet->available_balance, 0, ',', '.') }}</p>
        </div>
        <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form wire:submit.prevent="submit" class="p-6 md:p-8 space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nominal Penarikan (Rp)</label>
                <input type="number" wire:model.defer="amount" class="w-full px-4 py-3 rounded-xl border focus:ring-[#076f60] focus:border-[#076f60] bg-gray-50 focus:bg-white transition" placeholder="Minimal 50000">
                @error('amount') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bank</label>
                    <input type="text" wire:model.defer="bank_name" class="w-full px-4 py-3 rounded-xl border focus:ring-[#076f60] focus:border-[#076f60] bg-gray-50 focus:bg-white transition" placeholder="Contoh: BCA">
                    @error('bank_name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Rekening</label>
                    <input type="text" wire:model.defer="account_number" class="w-full px-4 py-3 rounded-xl border focus:ring-[#076f60] focus:border-[#076f60] bg-gray-50 focus:bg-white transition" placeholder="Nomor rekening">
                    @error('account_number') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemilik Rekening</label>
                <input type="text" wire:model.defer="account_name" class="w-full px-4 py-3 rounded-xl border focus:ring-[#076f60] focus:border-[#076f60] bg-gray-50 focus:bg-white transition" placeholder="Sesuai buku tabungan">
                @error('account_name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                <textarea wire:model.defer="notes" class="w-full px-4 py-3 rounded-xl border focus:ring-[#076f60] focus:border-[#076f60] bg-gray-50 focus:bg-white transition" rows="3" placeholder="Tambahkan catatan untuk Admin jika perlu..."></textarea>
                @error('notes') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" wire:loading.attr="disabled" class="w-full py-3.5 px-6 bg-[#076f60] text-white font-bold rounded-xl shadow-md hover:bg-[#05574b] transition flex items-center justify-center">
                    <span wire:loading.remove wire:target="submit">Kirim Pengajuan Withdraw</span>
                    <span wire:loading wire:target="submit">Memproses...</span>
                </button>
            </div>
        </form>
    </div>
</div>
