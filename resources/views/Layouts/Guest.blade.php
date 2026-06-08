<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arena - Marketplace Fasilitas Olahraga</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @livewireStyles
</head>
<body class="bg-white text-gray-900 font-sans antialiased flex flex-col min-h-screen">

    @include('components.guest.navbar')

    <main class="flex-grow">
        {{ $slot }}
    </main>

    @include('components.guest.footer')

    @livewireScripts
</body>
</html>