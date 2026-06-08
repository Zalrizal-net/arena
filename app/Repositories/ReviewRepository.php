<?php

namespace App\Repositories;

use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\Facility;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function createReview(array $data)
    {
        return Review::create($data);
    }

    public function createReviewImages(int $reviewId, array $imagePaths)
    {
        $images = array_map(function($path) use ($reviewId) {
            return [
                'review_id' => $reviewId, 
                'image_path' => $path
            ];
        }, $imagePaths);
        
        ReviewImage::insert($images);
    }

    public function getFacilityReviewsPaginated(int $facilityId, int $perPage = 10)
    {
        return Review::with(['user', 'images'])
            ->where('facility_id', $facilityId)
            ->latest()
            ->paginate($perPage);
    }

    public function hasUserReviewedBooking(int $userId, int $bookingId): bool
    {
        return Review::where('user_id', $userId)
            ->where('booking_id', $bookingId)
            ->exists();
    }

    public function updateFacilityRatingStats(int $facilityId)
    {
        $stats = Review::where('facility_id', $facilityId)
            ->select(DB::raw('avg(rating) as average_rating, count(id) as total_reviews'))
            ->first();

        Facility::where('id', $facilityId)->update([
            'average_rating' => $stats->average_rating ?? 0,
            'total_reviews' => $stats->total_reviews ?? 0,
        ]);
    }
}