<?php

namespace App\Repositories\Contracts;

interface ReviewRepositoryInterface
{
    public function createReview(array $data);
    public function createReviewImages(int $reviewId, array $imagePaths);
    public function getFacilityReviewsPaginated(int $facilityId, int $perPage = 10);
    public function hasUserReviewedBooking(int $userId, int $bookingId): bool;
    public function updateFacilityRatingStats(int $facilityId);
}