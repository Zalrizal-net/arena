<?php

namespace App\Services;

use App\Models\Facility;
use App\Repositories\Contracts\FacilityRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;

class FacilityService
{
    protected FacilityRepositoryInterface $facilityRepository;

    public function __construct(FacilityRepositoryInterface $facilityRepository)
    {
        $this->facilityRepository = $facilityRepository;
    }

    public function getPaginatedList(string $search = '', int $perPage = 8): LengthAwarePaginator
    {
        return $this->facilityRepository->getPaginated($search, $perPage);
    }

    public function getSellerFacilities(int $sellerId, string $search = '', string $category = '', int $perPage = 8): LengthAwarePaginator
    {
        return $this->facilityRepository->getPaginatedForSeller($sellerId, $search, $category, $perPage);
    }

    public function getFacilityDetail(int $id, int $sellerId): Facility
    {
        $facility = $this->facilityRepository->findById($id);

        if (!$facility) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Fasilitas tidak ditemukan.');
        }

        if ($facility->seller_id !== $sellerId) {
            throw new UnauthorizedException('Anda tidak memiliki akses ke fasilitas ini.');
        }

        return $facility;
    }

    public function storeFacility(array $data, int $sellerId): Facility
    {
        return DB::transaction(function () use ($data, $sellerId) {
            $data['seller_id'] = $sellerId;
            $data['slug'] = Str::slug($data['name']) . '-' . time();
            $data['status'] = 'active';

            if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
                $data['thumbnail'] = $data['thumbnail']->store('facilities/thumbnails', 'public');
            }

            $facility = $this->facilityRepository->create($data);

            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('facilities/galleries', 'public');
                        $this->facilityRepository->addImage($facility, $path);
                    }
                }
            }

            return $facility;
        });
    }

    public function updateFacility(int $id, array $data, int $sellerId): Facility
    {
        return DB::transaction(function () use ($id, $data, $sellerId) {
            $facility = $this->getFacilityDetail($id, $sellerId);

            $data['slug'] = Str::slug($data['name']) . '-' . time();

            if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
                if ($facility->thumbnail) {
                    Storage::disk('public')->delete($facility->thumbnail);
                }
                $data['thumbnail'] = $data['thumbnail']->store('facilities/thumbnails', 'public');
            } else {
                unset($data['thumbnail']);
            }

            $updatedFacility = $this->facilityRepository->update($facility, $data);

            if (isset($data['images'])) {
                foreach ($facility->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage->image_path);
                }
                $this->facilityRepository->clearImages($facility);

                foreach ($data['images'] as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('facilities/galleries', 'public');
                        $this->facilityRepository->addImage($updatedFacility, $path);
                    }
                }
            }

            return $updatedFacility;
        });
    }

    public function destroyFacility(int $id, int $sellerId): bool
    {
        $facility = $this->getFacilityDetail($id, $sellerId);
        return $this->facilityRepository->delete($facility);
    }

    public function getFacilityBySlug(string $slug): Facility
    {
        $facility = $this->facilityRepository->findBySlug($slug);

        if (!$facility) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Fasilitas tidak ditemukan.');
        }

        return $facility;
    }
}