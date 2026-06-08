<div>
    @include('components.dashboard.header', ['title' => 'Dashboard Penjual'])

    <div class="bg-white shadow rounded-lg p-6 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Halo, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600">
            Anda login sebagai <span class="font-bold text-[#076f60]">Penjual</span>. Pantau pesanan terbaru, kelola jadwal lapangan, dan optimalkan pendapatan dari layanan olahraga Anda di sini.
        </p>
    </div>
</div>