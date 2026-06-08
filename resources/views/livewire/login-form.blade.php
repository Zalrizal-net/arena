<div class="py-12 flex justify-center bg-gray-50 min-h-screen">
    <div class="w-full max-w-md">
        <div class="bg-white py-8 px-6 shadow-md rounded-xl border border-gray-100">
            <h2 class="text-center text-2xl font-extrabold text-gray-900 mb-6">Masuk ke Arena</h2>
            
            <form wire:submit.prevent="login" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="email" type="email" wire:model.defer="email" placeholder="nama@email.com" 
                            class="focus:ring-[#076f60] focus:border-[#076f60] block w-full sm:text-sm border-gray-300 rounded-md py-2.5 px-3 border transition duration-150 ease-in-out">
                    </div>
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="#" class="text-sm font-medium text-[#076f60] hover:text-[#05574b]">Lupa Password?</a>
                    </div>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="password" type="password" wire:model.defer="password" placeholder="••••••••" 
                            class="focus:ring-[#076f60] focus:border-[#076f60] block w-full sm:text-sm border-gray-300 rounded-md py-2.5 px-3 border transition duration-150 ease-in-out">
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember" type="checkbox" wire:model.defer="remember" 
                        class="h-4 w-4 text-[#076f60] focus:ring-[#076f60] border-gray-300 rounded cursor-pointer">
                    <label for="remember" class="ml-2 block text-sm text-gray-900 cursor-pointer">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <div>
                    <button type="button" wire:click.prevent="login" wire:loading.attr="disabled" 
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#076f60] hover:bg-[#05574b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#076f60] disabled:opacity-70 disabled:cursor-wait transition duration-150 ease-in-out">
                            
                            <span wire:loading.remove wire:target="login">Masuk &rarr;</span>
                            <span wire:loading wire:target="login">Sedang memproses...</span>
                    </button>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-semibold text-[#076f60] hover:text-[#05574b]">Daftar Sekarang</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
    
    <script>
    window.addEventListener('force-redirect', event => {
        window.location.href = event.detail.url;
    });
</script>
</div>

