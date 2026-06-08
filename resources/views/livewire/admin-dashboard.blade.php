<div>
    @include('components.dashboard.header', ['title' => 'Dashboard Admin'])

    <div class="bg-white shadow rounded-lg p-6 border border-gray-100">
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Selamat datang, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-600">
            Anda login sebagai <span class="font-bold text-[#076f60]">Admin</span>. Di sini Anda memiliki akses penuh untuk mengelola seluruh pengguna, memverifikasi penjual, dan memantau transaksi platform Arena.
        </p>
    </div>
</div>