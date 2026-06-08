<?php

namespace App\Http\Livewire\Buyer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ReviewService;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Exception;

class ReviewForm extends Component
{
    use WithFileUploads;

    public $booking_id;
    public $facility_name;
    public $rating = 5; // Default bintang 5
    public $comment = '';
    public $images = [];

    public function mount($bookingId)
    {
        $this->booking_id = $bookingId;
        // Ambil nama fasilitas sekadar untuk UI
        $booking = Booking::with('facility')->findOrFail($bookingId);
        $this->facility_name = $booking->facility->name;
    }

    public function submitReview(ReviewService $reviewService)
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'images.*' => 'image|max:2048',
            'images' => 'max:5',
        ]);

        try {
            $reviewService->createReview(Auth::id(), [
                'booking_id' => $this->booking_id,
                'rating' => $this->rating,
                'comment' => $this->comment,
            ], $this->images);

            session()->flash('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
            return redirect()->route('booking.history');
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.buyer.review-form')->layout('layouts.app');
    }
}