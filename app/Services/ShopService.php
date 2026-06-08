<?php

namespace App\Services;

use App\Repositories\Contracts\ShopRepositoryInterface;

class ShopService
{
    public function __construct(
        private ShopRepositoryInterface $shopRepository
    ) {}

    public function getShopDetailsBySlug(string $slug)
    {
        // 1. Ambil Profil Toko
        $shop = $this->shopRepository->findBySlug($slug);
        
        // 2. Ambil Statistik Toko (Rating, Total Facility, Total Review)
        $stats = $this->shopRepository->getShopStats($shop->user_id);

        return [
            'profile' => $shop,
            'stats'   => $stats,
        ];
    }

    public function getShopFacilities(int $sellerId, array $filters, int $perPage = 12)
    {
        return $this->shopRepository->getShopFacilitiesPaginated($sellerId, $filters, $perPage);
    }
    public function getAllShops(int $perPage = 10)
    {
        return $this->shopRepository->getAllShopsPaginated($perPage);
    }
}