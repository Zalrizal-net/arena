<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <h2 class="text-center text-3xl font-extrabold text-gray-900">
                Lupa Password
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Masukkan alamat email Anda dan kami akan mengirimkan kode OTP untuk mereset kata sandi.
            </p>
        </div>

        <form wire:submit.prevent="sendOtp" class="mt-8 space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input wire:model.defer="email" id="email" type="email" required class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60] sm:text-sm mt-1">
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-[#076f60] hover:bg-[#05574b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#076f60] transition-colors">
                    <span wire:loading wire:target="sendOtp" class="mr-2">...</span>
                    Kirim Kode OTP
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm font-medium text-[#076f60] hover:text-[#05574b]">
                &larr; Kembali ke halaman Login
            </a>
        </div>
    </div>
</div>