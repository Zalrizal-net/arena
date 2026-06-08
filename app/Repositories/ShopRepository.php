<?php

namespace App\Repositories;

use App\Models\SellerProfile;
use App\Models\Facility;
use App\Repositories\Contracts\ShopRepositoryInterface;

class ShopRepository implements ShopRepositoryInterface
{
    public function findBySlug(string $slug)
    {
        return SellerProfile::with('user')->where('shop_slug', $slug)->firstOrFail();
    }

    public function getShopStats(int $sellerId)
    {
        // Menghitung total facility milik seller
        $totalFacilities = Facility::where('seller_id', $sellerId)->count(); // Sesuaikan kolom seller_id/user_id

        // Menghitung total seluruh review dari semua facility milik seller
        $totalReviews = Facility::where('seller_id', $sellerId)->sum('total_reviews');

        // LOGIC RATING TOKO: Rata-rata dari kolom average_rating fasilitas yang memiliki rating
        $averageRating = Facility::where('seller_id', $sellerId)
            ->where('average_rating', '>', 0)
            ->avg('average_rating');

        return [
            'total_facilities' => $totalFacilities,
            'total_reviews'    => (int) $totalReviews,
            'average_rating'   => $averageRating ? round($averageRating, 2) : 0,
        ];
    }

    public function getShopFacilitiesPaginated(int $sellerId, array $filters, int $perPage = 12)
    {
        $query = Facility::where('seller_id', $sellerId); // Sesuaikan foreign key

        // FILTER: Search (Pencarian nama fasilitas)
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        // FILTER: Sorting
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'lowest_price':
                    $query->orderBy('price_per_hour', 'asc');
                    break;
                case 'highest_price':
                    $query->orderBy('price_per_hour', 'desc');
                    break;
                case 'newest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest(); // Default sort
        }

        return $query->paginate($perPage);
    }
    public function getAllShopsPaginated(int $perPage = 10)
    {
        return SellerProfile::with('user')->latest()->paginate($perPage);
    }
}