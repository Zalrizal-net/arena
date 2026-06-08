<div>
    <style>
        /* Animasi Background Gradien yang Lebih Kontras */
        @keyframes gradient-move {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient-bg {
            /* Diperbesar agar perubahan warnanya sangat ketara */
            background-size: 300% 300%; 
            animation: gradient-move 6s ease-in-out infinite;
        }

        /* Animasi Teks Bergantian (Text Slider) */
        @keyframes text-fade {
            0% { opacity: 0; transform: translateY(20px); }
            5% { opacity: 1; transform: translateY(0); }
            20% { opacity: 1; transform: translateY(0); }
            25% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 0; transform: translateY(-20px); }
        }
        
        /* Total durasi 12 detik, masing-masing teks mendapat jatah tampil 3 detik */
        .text-anim-1 { animation: text-fade 12s ease-in-out infinite 0s; }
        .text-anim-2 { animation: text-fade 12s ease-in-out infinite 3s; }
        .text-anim-3 { animation: text-fade 12s ease-in-out infinite 6s; }
        .text-anim-4 { animation: text-fade 12s ease-in-out infinite 9s; }
    </style>

    <div class="relative bg-gradient-to-r from-[#6ee7b7] via-[#f0fdfa] to-[#5eead4] animate-gradient-bg overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="text-center lg:text-left z-10">
                    <p class="text-sm sm:text-base text-gray-800 mb-6 max-w-md mx-auto lg:mx-0 leading-relaxed font-medium">
                        Satu platform untuk semua kebutuhan olahraga Anda. Dari penyewaan lapangan hingga perlengkapan profesional, semua dalam satu genggaman.
                    </p>
                    
                    <h1 class="text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl mb-10">
                        <span class="block text-[#076f60] mb-2">Temukan Arena</span>
                        <span class="block text-gray-900">Olahraga Anda</span>
                    </h1>
                    
                    <div class="flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-4">
                        <a href="{{ route('facilities.index') }}" class="flex items-center justify-center px-5 py-4 rounded-xl text-white bg-[#076f60] hover:bg-[#05574b] transition shadow-lg w-full sm:w-auto hover:-translate-y-1 duration-300">
                            <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="text-sm font-semibold text-left leading-tight">Cari Fasilitas<br>Olahraga</span>
                        </a>
                        
                        <a href="#kursus" class="flex items-center justify-center px-5 py-4 rounded-xl text-white bg-[#076f60] hover:bg-[#05574b] transition shadow-lg w-full sm:w-auto hover:-translate-y-1 duration-300">
                            <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="text-sm font-semibold text-left leading-tight">Cari<br>Kursus/Komunitas</span>
                        </a>
                        
                        <a href="#produk" class="flex items-center justify-center px-5 py-4 rounded-xl text-white bg-[#076f60] hover:bg-[#05574b] transition shadow-lg w-full sm:w-auto hover:-translate-y-1 duration-300">
                            <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <span class="text-sm font-semibold text-left leading-tight">Cari Produk<br>Olahraga</span>
                        </a>
                    </div>
                </div>

                <div class="flex justify-center lg:justify-end mt-8 lg:mt-0 z-10">
                    <div class="w-full max-w-md aspect-square bg-black rounded-3xl shadow-2xl flex items-center justify-center transform hover:scale-105 transition duration-500 relative overflow-hidden">
                        
                        <div class="absolute w-full px-6 text-center opacity-0 text-anim-1">
                            <span class="text-white text-3xl md:text-4xl font-bold tracking-wide">Mau olahraga?</span>
                        </div>

                        <div class="absolute w-full px-6 text-center opacity-0 text-anim-2">
                            <span class="text-white text-3xl md:text-4xl font-bold tracking-wide">Bingung cari tempat?</span>
                        </div>

                        <div class="absolute w-full px-6 text-center opacity-0 text-anim-3">
                            <span class="text-white text-4xl md:text-5xl font-extrabold tracking-widest uppercase">Kunjungi ARENA</span>
                        </div>

                        <div class="absolute w-full px-6 text-center opacity-0 text-anim-4">
                            <span class="inline-block bg-white text-black px-6 py-3 rounded-full text-2xl md:text-3xl font-bold tracking-widest shadow-lg">www.arena.id</span>
                        </div>

                    </div>
                </div>
                
            </div>
        </div>
        
        <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full overflow-hidden -z-0 pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-teal-200/30 blur-3xl"></div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-24">
        
        <section id="fasilitas">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-extrabold text-gray-900">Fasilitas Terpopuler</h2>
                <a href="{{ route('facilities.index') }}" class="text-sm font-semibold text-[#076f60] hover:text-[#05574b] hover:underline">Lihat Semua &rarr;</a>
            </div>

            @if($facilities->isEmpty())
                <div class="text-center py-16 border border-dashed border-gray-300 rounded-2xl bg-gray-50">
                    <p class="text-gray-500 text-sm">Tidak ada data fasilitas</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($facilities as $facility)
                        <x-card-katalog 
                            :title="$facility->name"
                            :subtitle="$facility->city"
                            :price="$facility->price_per_hour"
                            :image="$facility->thumbnail"
                            :rating="4.8"
                            :link="route('facility.show', $facility->slug)"
                            type="fasilitas"
                        />
                    @endforeach
                </div>
            @endif
        </section>

        <section id="kursus">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-extrabold text-gray-900">Kursus Terpopuler</h2>
                <a href="#" class="text-sm font-semibold text-[#076f60] hover:text-[#05574b] hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="text-center py-16 border border-dashed border-gray-300 rounded-2xl bg-gray-50">
                <p class="text-gray-500 text-sm">Tidak ada data kursus</p>
            </div>
        </section>

        <section id="produk">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-extrabold text-gray-900">Produk Olahraga</h2>
                <a href="#" class="text-sm font-semibold text-[#076f60] hover:text-[#05574b] hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="text-center py-16 border border-dashed border-gray-300 rounded-2xl bg-gray-50">
                <p class="text-gray-500 text-sm">Tidak ada data produk</p>
            </div>
        </section>

    </div>
</div>