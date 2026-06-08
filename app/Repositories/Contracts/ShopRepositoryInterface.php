<?php

namespace App\Repositories\Contracts;

interface ShopRepositoryInterface
{
    public function findBySlug(string $slug);
    public function getShopStats(int $sellerId);
    public function getShopFacilitiesPaginated(int $sellerId, array $filters, int $perPage = 12);
    public function getAllShopsPaginated(int $perPage = 10);
}