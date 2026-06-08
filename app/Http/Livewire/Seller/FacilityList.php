<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\FacilityService;
use Illuminate\Support\Facades\Auth;

class FacilityList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function deleteFacility(int $id, FacilityService $facilityService)
    {
        try {
            $facilityService->destroyFacility($id, Auth::id());
            session()->flash('success', 'Fasilitas berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render(FacilityService $facilityService)
    {
        $facilities = $facilityService->getSellerFacilities(
            Auth::id(),
            $this->search,
            $this->category,
            6
        );

        return view('livewire.seller.facility-list', [
            'facilities' => $facilities
        ])->layout('layouts.app');
    }
}