<?php

namespace App\Services;

use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Models\Booking;
use Exception;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository
    ) {}

    public function createReview(int $userId, array $data, array $imageFiles = [])
    {
        $booking = Booking::with('facility')->findOrFail($data['booking_id']);

        // LOGIC VALIDASI REVIEW: Hanya owner booking
        if ($booking->user_id !== $userId) {
            throw new Exception("Anda tidak memiliki akses untuk memberikan ulasan pada pesanan ini.");
        }

        // LOGIC VALIDASI REVIEW: Hanya booking completed & paid
        if ($booking->status !== 'completed' || $booking->payment_status !== 'paid') {
            throw new Exception("Ulasan hanya dapat diberikan setelah Anda selesai menggunakan fasilitas (Status: Completed).");
        }

        // LOGIC VALIDASI REVIEW: Hanya 1 review per booking
        if ($this->reviewRepository->hasUserReviewedBooking($userId, $booking->id)) {
            throw new Exception("Anda sudah memberikan ulasan untuk pesanan ini.");
        }

        DB::beginTransaction();
        try {
            // Simpan Review Utama
            $review = $this->reviewRepository->createReview([
                'facility_id' => $booking->facility_id,
                'booking_id' => $booking->id,
                'user_id' => $userId,
                'rating' => $data['rating'],
                'comment' => $data['comment'],
            ]);

            // Simpan Foto Review Jika Ada
            if (!empty($imageFiles)) {
                $imagePaths = [];
                foreach ($imageFiles as $file) {
                    $path = $file->store('reviews', 'public');
                    $imagePaths[] = $path;
                }
                $this->reviewRepository->createReviewImages($review->id, $imagePaths);
            }

            // LOGIC RATING AVERAGE: Update rating rata-rata di tabel Facility
            $this->reviewRepository->updateFacilityRatingStats($booking->facility_id);

            DB::commit();
            return $review;
            
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getFacilityReviews(int $facilityId, int $perPage = 5)
    {
        return $this->reviewRepository->getFacilityReviewsPaginated($facilityId, $perPage);
    }
}