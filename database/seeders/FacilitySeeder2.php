<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User; // Tambahkan ini untuk memanggil model User

class FacilitySeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. AMBIL ID USER YANG ADA DI DATABASE
        // Jika Abang punya kolom 'role', gunakan: User::where('role', 'seller')->pluck('id')->toArray();
        // Untuk amannya sekarang, kita ambil semua ID user yang ada:
        $sellerIds = User::pluck('id')->toArray();

        // 2. CEK APAKAH ADA USER
        if (empty($sellerIds)) {
            $this->command->error('GAGAL: Tidak ada data user sama sekali di database!');
            $this->command->warn('Solusi: Silakan register/buat akun user manual dulu di web, atau jalankan UserSeeder, baru jalankan FacilitySeeder ini lagi.');
            return; // Hentikan seeder agar tidak error
        }

        $cities = [
            'Jakarta', 'Bandung', 'Surabaya', 'Semarang', 'Yogyakarta',
            'Medan', 'Makassar', 'Denpasar', 'Palembang', 'Balikpapan'
        ];

        // Link gambar spesifik per kategori dari Unsplash agar relevan dan tidak broken
        $images = [
            'Futsal' => [
                'https://images.unsplash.com/photo-1534158914592-062992fbe900?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1574629810360-7efbb211d4da?q=80&w=800&auto=format&fit=crop'
            ],
            'Basket' => [
                'https://images.unsplash.com/photo-1505666287802-931dc83948e9?q=80&w=800&auto=format&fit=crop'
            ],
            'Tenis' => [
                'https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?q=80&w=800&auto=format&fit=crop'
            ],
            'Badminton' => [
                'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1599839619722-39751411ea63?q=80&w=800&auto=format&fit=crop'
            ],
            'Padel' => [
                'https://images.unsplash.com/photo-1622228837330-90928929e009?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1622228837686-932f91361c47?q=80&w=800&auto=format&fit=crop'
            ],
            'Sepak Bola' => [
                'https://images.unsplash.com/photo-1459865264687-595d652de67e?q=80&w=800&auto=format&fit=crop'
            ]
        ];

        // Format komposisi fasilitas per kota
        $compositions = [
            ['category' => 'Futsal', 'count' => 2, 'price_min' => 100000, 'price_max' => 200000],
            ['category' => 'Basket', 'count' => 1, 'price_min' => 150000, 'price_max' => 300000],
            ['category' => 'Tenis', 'count' => 1, 'price_min' => 120000, 'price_max' => 250000],
            ['category' => 'Badminton', 'count' => 2, 'price_min' => 50000, 'price_max' => 100000],
            ['category' => 'Padel', 'count' => 2, 'price_min' => 200000, 'price_max' => 400000],
            ['category' => 'Sepak Bola', 'count' => 1, 'price_min' => 500000, 'price_max' => 1500000],
        ];

        $facilities = [];
        $now = Carbon::now();

        foreach ($cities as $city) {
            foreach ($compositions as $comp) {
                for ($i = 1; $i <= $comp['count']; $i++) {
                    
                    $name = "Arena " . $comp['category'] . " Premium " . $i . " " . $city;
                    $slug = Str::slug($name);
                    
                    // Mengambil gambar random dari array kategori terkait
                    $thumbnail = $images[$comp['category']][array_rand($images[$comp['category']])];
                    
                    // Harga kelipatan 10.000
                    $price = rand($comp['price_min'] / 10000, $comp['price_max'] / 10000) * 10000;

                    // Koordinat dummy sekitar wilayah Indonesia
                    $lat = -0.789275 + (rand(-5000, 5000) / 10000);
                    $lng = 113.921327 + (rand(-5000, 5000) / 10000);

                    $facilities[] = [
                        // KUNCI PERBAIKAN: Ambil ID secara acak dari array $sellerIds yang valid
                        'seller_id'      => $sellerIds[array_rand($sellerIds)], 
                        'name'           => $name,
                        'slug'           => $slug,
                        'category'       => $comp['category'],
                        'city'           => $city,
                        'address'        => "Jl. Olahraga No. " . rand(1, 99) . ", Pusat Kota " . $city . ", Indonesia",
                        'description'    => "Fasilitas " . $comp['category'] . " terbaik di kota " . $city . " dengan standar internasional. Dilengkapi dengan ruang ganti yang nyaman, area parkir luas, dan pencahayaan optimal untuk permainan siang maupun malam hari. Cocok untuk latihan rutin maupun turnamen.",
                        'price_per_hour' => $price,
                        'thumbnail'      => $thumbnail,
                        'status'         => 'active',
                        'latitude'       => $lat,
                        'longitude'      => $lng,
                        'created_at'     => $now,
                        'updated_at'     => $now,
                    ];
                }
            }
        }

        // Insert menggunakan chunk agar memori aman
        $chunks = array_chunk($facilities, 20);
        foreach ($chunks as $chunk) {
            DB::table('facilities')->insert($chunk);
        }

        $this->command->info('Berhasil! Seeder fasilitas sukses dijalankan.');
    }
}