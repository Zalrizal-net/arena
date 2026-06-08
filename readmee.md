# Arena - Mobile App (Flutter)

Arena adalah aplikasi mobile *marketplace* untuk penyewaan fasilitas olahraga, terintegrasi dengan backend Laravel (REST API) dan sistem Escrow.

## Arsitektur Proyek
Aplikasi ini menggunakan pendekatan **Feature-First Architecture** untuk memastikan skalabilitas dan isolasi fitur antara Publik, Pembeli (Buyer), dan Penjual (Seller).

### Tech Stack
- **Framework:** Flutter
- **Design System:** Material 3 (Tailwind-inspired styling)
- **Networking:** Dio / HTTP (dengan Sanctum Interceptors)
- **Real-time:** Pusher Client (Laravel Echo compatible)

### Struktur Folder
```text
lib/
├── core/           # Utilitas global (API client, theme, formatter)
├── features/       # Fitur terisolasi (auth, buyer, seller, chat)
├── shared/         # Reusable UI widgets (buttons, cards)
├── routes/         # Konfigurasi navigasi
└── main.dart       # Entry point

Untuk Agen AI yang beroperasi di workspace ini:

Dilarang memodifikasi kode inti tanpa persetujuan (Gunakan Planning Mode).

Tulis kode secara utuh, fungsional, dan tanpa blok komentar // isi logika di sini.

Patuhi batas arsitektur: Jangan mencampur logika UI (Screen) dengan logika Data (Controller/Service).

Selalu pastikan respons JSON dari API dipetakan ke dalam Model yang strongly-typed.