<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-sm border border-gray-100">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-[#e6f4f1] mb-4">
                <svg class="h-6 w-6 text-[#076f60]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900">Cek Email Anda</h2>
            <p class="mt-2 text-sm text-gray-600">
                Kami telah mengirimkan 6 digit kode OTP ke <br> <span class="font-bold text-gray-900">{{ $email }}</span>
            </p>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm text-center">
                {{ session('message') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="verify" class="mt-8 space-y-6">
            <div>
                <label for="otp_code" class="block text-sm font-medium text-gray-700 text-center">Masukkan Kode OTP</label>
                <input wire:model.defer="otp_code" id="otp_code" type="text" maxlength="6" required class="mt-2 text-center text-2xl tracking-[0.5em] appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-300 text-gray-900 focus:outline-none focus:ring-[#076f60] focus:border-[#076f60]" placeholder="••••••">
                @error('otp_code') <span class="text-red-500 text-xs mt-2 block text-center">{{ $message }}</span> @enderror
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-[#076f60] hover:bg-[#05574b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#076f60] transition-colors">
                    <span wire:loading wire:target="verify" class="mr-2">...</span>
                    Verifikasi Akun
                </button>
            </div>
        </form>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Belum menerima kode? 
                <button wire:click="resend" type="button" class="font-medium text-[#076f60] hover:text-[#05574b] focus:outline-none">
                    <span wire:loading wire:target="resend">Mengirim...</span>
                    <span wire:loading.remove wire:target="resend">Kirim Ulang OTP</span>
                </button>
            </p>
        </div>
    </div>
</div>