<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Services\ReviewService;

class ReviewController extends Controller
{
    public function __construct(
        private ReviewService $reviewService
    ) {}

    /**
     * Menampilkan daftar ulasan untuk satu fasilitas (Public API)
     */
    public function index($facilityId)
    {
        // Parameter kedua (5) adalah limit per halaman, bisa disesuaikan.
        $reviews = $this->reviewService->getFacilityReviews($facilityId, 5);
        
        return ReviewResource::collection($reviews);
    }

    /**
     * Menyimpan ulasan baru dari Mobile App (Protected API)
     */
    public function store(StoreReviewRequest $request)
    {
        try {
            // Service akan memvalidasi apakah status booking sudah completed & milik user tersebut
            $review = $this->reviewService->createReview(
                $request->user()->id, 
                $request->validated(),
                $request->file('images') ?? []
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Ulasan berhasil dikirim.', 
                'data' => new ReviewResource($review)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}