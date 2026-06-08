<?php

namespace App\Repositories;

use App\Models\Facility;
use App\Repositories\Contracts\FacilityRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FacilityRepository implements FacilityRepositoryInterface
{
    public function getPaginated(string $search = '', int $perPage = 8): LengthAwarePaginator
    {
        return Facility::where('status', 'active')
            ->where('name', 'like', '%' . $search . '%')
            ->latest()
            ->paginate($perPage);
    }

    public function getPaginatedForSeller(int $sellerId, string $search = '', string $category = '', int $perPage = 8): LengthAwarePaginator
    {
        $query = Facility::where('seller_id', $sellerId);

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if (!empty($category)) {
            $query->where('category', $category);
        }

        return $query->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Facility
    {
        return Facility::with('images')->find($id);
    }

    public function findBySlug(string $slug): ?Facility
    {
        return Facility::with(['images', 'seller'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();
    }

    public function create(array $data): Facility
    {
        return Facility::create($data);
    }

    public function update(Facility $facility, array $data): Facility
    {
        $facility->update($data);
        return $facility;
    }

    public function delete(Facility $facility): bool
    {
        return $facility->delete();
    }

    public function addImage(Facility $facility, string $path): void
    {
        $facility->images()->create([
            'image_path' => $path,
            'is_primary' => false
        ]);
    }

    public function clearImages(Facility $facility): void
    {
        $facility->images()->delete();
    }
}