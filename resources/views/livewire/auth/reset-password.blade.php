<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h2 class="text-center text-2xl font-extrabold text-gray-900">
                Buat Password Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Masukkan kode OTP yang dikirim ke <br><span class="font-bold">{{ $email }}</span>
            </p>
        </div>

        <form wire:submit.prevent="resetPassword" class="mt-8 space-y-6">
            <div class="space-y-4">
                <div>
                    <label for="otp_code" class="block text-sm font-medium text-gray-700">Kode OTP 6 Digit</label>
                    <input wire:model.defer="otp_code" id="otp_code" type="text" maxlength="6" required class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm mt-1 text-center tracking-widest font-bold">
                    @error('otp_code') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="pt-2 border-t border-gray-100"></div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input wire:model.defer="password" id="password" type="password" required class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm mt-1">
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                    <input wire:model.defer="password_confirmation" id="password_confirmation" type="password" required class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm mt-1">
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-[#076f60] hover:bg-[#05574b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#076f60] transition-colors">
                    <span wire:loading wire:target="resetPassword" class="mr-2">...</span>
                    Simpan Password Baru
                </button>
            </div>
        </form>
    </div>
</div>