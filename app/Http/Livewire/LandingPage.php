<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\FacilityService;

class LandingPage extends Component
{
    // Pastikan TIDAK ADA deklarasi public $facilities = []; di sini

    public function render()
    {
        $facilityService = app(FacilityService::class);

        return view('livewire.landing-page', [
            // Data langsung dikirim (inject) ke view sebagai Paginator
            'facilities' => $facilityService->getPaginatedList('', 4)
        ])->layout('layouts.guest');
    }
}