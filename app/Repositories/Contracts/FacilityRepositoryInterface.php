<?php

namespace App\Repositories\Contracts;

use App\Models\Facility;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface FacilityRepositoryInterface
{
    public function getPaginated(string $search = '', int $perPage = 8): LengthAwarePaginator;
    public function getPaginatedForSeller(int $sellerId, string $search = '', string $category = '', int $perPage = 8): LengthAwarePaginator;
    public function findById(int $id): ?Facility;
    public function create(array $data): Facility;
    public function update(Facility $facility, array $data): Facility;
    public function delete(Facility $facility): bool;
    public function addImage(Facility $facility, string $path): void;
    public function clearImages(Facility $facility): void;
    public function findBySlug(string $slug): ?Facility;
}