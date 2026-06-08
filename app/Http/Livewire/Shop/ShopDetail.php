<?php

namespace App\Http\Livewire\Shop;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\ShopService;
use Exception;

class ShopDetail extends Component
{
    use WithPagination;

    public $slug;
    public $shop;
    public $stats;
    
    public $search = '';
    public $sort = 'newest';

    protected $queryString = [
        'search' => ['except' => ''],
        'sort' => ['except' => 'newest'],
    ];

    public function mount($slug)
    {
        $this->slug = $slug;
        
        try {
            $shopService = app(ShopService::class);
            $data = $shopService->getShopDetailsBySlug($this->slug);
            
            $this->shop = $data['profile'];
            $this->stats = $data['stats'];
        } catch (Exception $e) {
            abort(404, 'Toko tidak ditemukan');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function render(ShopService $shopService)
    {
        $filters = [
            'search' => $this->search,
            'sort'   => $this->sort,
        ];

        $facilities = $shopService->getShopFacilities($this->shop->user_id, $filters, 12);

        return view('livewire.shop.shop-detail', [
            'facilities' => $facilities,
        ])->layout('layouts.guest');
    }
}