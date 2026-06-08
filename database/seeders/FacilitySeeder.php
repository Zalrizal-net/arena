<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class FacilitySeeder extends Seeder
{
    public function run()
    {
        $seller = User::where('role', 'seller')->first();

        if (!$seller) {
            $seller = User::create([
                'name' => 'Seller Juragan Arena',
                'email' => 'seller@arena.com',
                'phone' => '081299998888',
                'password' => Hash::make('password123'),
                'role' => 'seller',
            ]);
        }

        $faker = Faker::create('id_ID');

        $categories = ['futsal', 'badminton', 'basket', 'tenis', 'renang', 'gym'];
        $cities = ['Jakarta Selatan', 'Jakarta Barat', 'Tangerang Selatan', 'Bandung', 'Surabaya', 'Medan', 'Yogyakarta', 'Denpasar'];
        $adjectives = ['Pro', 'Elite', 'Champion', 'Victory', 'Internasional', 'Prima', 'Utama', 'Center', 'Arena'];

        for ($i = 1; $i <= 30; $i++) {
            $category = $faker->randomElement($categories);
            $cityName = $faker->randomElement($cities);
            $adjective = $faker->randomElement($adjectives);
            
            $facilityName = ucfirst($category) . ' ' . $adjective . ' ' . $cityName;
            $price = $faker->numberBetween(5, 35) * 10000;
            
            // Menggunakan link eksternal acak dengan seed unik per item
            $randomImageLink = 'https://picsum.photos/seed/arena' . $i . '/800/600';

            Facility::create([
                'seller_id' => $seller->id,
                'name' => $facilityName,
                'slug' => Str::slug($facilityName) . '-' . time() . '-' . $i,
                'category' => $category,
                'city' => $cityName,
                'address' => $faker->streetAddress() . ', ' . $cityName,
                'description' => "Fasilitas olahraga " . $category . " berstandar tinggi yang berlokasi strategis di " . $cityName . ". " . $faker->paragraph(3),
                'price_per_hour' => $price,
                'thumbnail' => $randomImageLink, 
                'status' => $faker->randomElement(['active', 'active', 'active', 'inactive']),
                'latitude' => $faker->latitude(-9.0, 5.0),
                'longitude' => $faker->longitude(95.0, 141.0),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
        }
    }
}