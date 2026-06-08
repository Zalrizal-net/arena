<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\ReviewService;
use App\Models\Facility;

class ReviewList extends Component
{
    use WithPagination;

    public $facilityId;
    public $facility;

    public function mount($facilityId)
    {
        $this->facilityId = $facilityId;
        $this->facility = Facility::findOrFail($facilityId);
    }

    public function render(ReviewService $reviewService)
    {
        $reviews = $reviewService->getFacilityReviews($this->facilityId, 5); // 5 review per halaman

        return view('livewire.review-list', [
            'reviews' => $reviews
        ]);
    }
}