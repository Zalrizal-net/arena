<div>
    <div class="max-w-3xl">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-gray-500 mt-1">Kelola informasi pribadi dan kontak akun Anda.</p>
        </div>

        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="mb-6 bg-green-50 text-green-700 p-4 rounded-xl border border-green-100 flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form wire:submit.prevent="updateProfile" class="p-6 md:p-8">
                <div class="flex items-center gap-6 mb-8 pb-8 border-b border-gray-100">
                    <div class="w-24 h-24 bg-[#076f60] text-white rounded-full flex items-center justify-center text-4xl font-bold shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Foto Profil</h3>
                        <p class="text-sm text-gray-500">Saat ini menggunakan inisial nama secara otomatis.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" wire:model.defer="name" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-300 focus:ring-red-500' : 'border-gray-200 focus:ring-[#076f60] focus:border-[#076f60]' }} transition shadow-sm bg-gray-50 focus:bg-white">
                        @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" wire:model.defer="email" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-300 focus:ring-red-500' : 'border-gray-200 focus:ring-[#076f60] focus:border-[#076f60]' }} transition shadow-sm bg-gray-50 focus:bg-white">
                        @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon / WhatsApp</label>
                        <input type="text" wire:model.defer="phone" placeholder="Contoh: 081234567890" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('phone') ? 'border-red-300 focus:ring-red-500' : 'border-gray-200 focus:ring-[#076f60] focus:border-[#076f60]' }} transition shadow-sm bg-gray-50 focus:bg-white">
                        @error('phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" wire:loading.attr="disabled" class="py-3 px-8 bg-[#076f60] text-white font-bold rounded-xl shadow-md hover:bg-[#05574b] transition flex items-center">
                        <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                        <span wire:loading wire:target="updateProfile">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>