<div class="py-12 flex justify-center bg-gray-50 min-h-screen">
    <div class="w-full max-w-lg">
        <div class="bg-white py-8 px-6 shadow-md rounded-xl border border-gray-100">
            <h2 class="text-center text-2xl font-extrabold text-gray-900 mb-6">Buat Akun Baru</h2>
            
            <form wire:submit.prevent="register" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Sebagai</label>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" wire:click="selectRole('buyer')" 
                            class="flex justify-center items-center py-2 px-4 border rounded-md transition-colors duration-150 ease-in-out focus:outline-none {{ $role === 'buyer' ? 'border-[#076f60] bg-[#e6f4f1] text-[#076f60] font-semibold' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}">
                            Pembeli
                        </button>
                        <button type="button" wire:click="selectRole('seller')" 
                            class="flex justify-center items-center py-2 px-4 border rounded-md transition-colors duration-150 ease-in-out focus:outline-none {{ $role === 'seller' ? 'border-[#076f60] bg-[#e6f4f1] text-[#076f60] font-semibold' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' }}">
                            Penjual
                        </button>
                    </div>
                    <input type="hidden" wire:model="role">
                    @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input id="name" type="text" wire:model.defer="name" placeholder="John Doe" 
                            class="mt-1 focus:ring-[#076f60] focus:border-[#076f60] block w-full sm:text-sm border-gray-300 rounded-md py-2.5 px-3 border">
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                        <input id="phone" type="text" wire:model.defer="phone" placeholder="0812xxxx" 
                            class="mt-1 focus:ring-[#076f60] focus:border-[#076f60] block w-full sm:text-sm border-gray-300 rounded-md py-2.5 px-3 border">
                        @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" wire:model.defer="email" placeholder="email@perusahaan.com" 
                        class="mt-1 focus:ring-[#076f60] focus:border-[#076f60] block w-full sm:text-sm border-gray-300 rounded-md py-2.5 px-3 border">
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" type="password" wire:model.defer="password" placeholder="••••••••" 
                            class="mt-1 focus:ring-[#076f60] focus:border-[#076f60] block w-full sm:text-sm border-gray-300 rounded-md py-2.5 px-3 border">
                        @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi</label>
                        <input id="password_confirmation" type="password" wire:model.defer="password_confirmation" placeholder="••••••••" 
                            class="mt-1 focus:ring-[#076f60] focus:border-[#076f60] block w-full sm:text-sm border-gray-300 rounded-md py-2.5 px-3 border">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled" 
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#076f60] hover:bg-[#05574b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#076f60] disabled:opacity-70 disabled:cursor-wait">
                        <span wire:loading.remove wire:target="register">Daftar Sekarang</span>
                        <span wire:loading wire:target="register">Sedang memproses...</span>
                    </button>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        Sudah memiliki akun? 
                        <a href="{{ route('login') }}" class="font-semibold text-[#076f60] hover:text-[#05574b]">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>