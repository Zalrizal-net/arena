<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\FacilityService;
use Illuminate\Support\Facades\Auth;

class FacilityCreate extends Component
{
    use WithFileUploads;

    public $name;
    public $category = '';
    public $city;
    public $address;
    public $description;
    public $price_per_hour;
    public $status = 'active';
    
    public $thumbnail;
    public $images = []; // Array untuk multiple upload gallery

    protected $rules = [
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'address' => 'required|string',
        'description' => 'required|string',
        'price_per_hour' => 'required|numeric|min:0',
        'status' => 'required|in:active,inactive',
        'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ];

    protected $messages = [
        'required' => 'Kolom :attribute wajib diisi.',
        'numeric' => 'Kolom :attribute harus berupa angka.',
        'image' => 'File harus berupa gambar.',
        'max' => 'Ukuran maksimal file adalah 2MB.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save(FacilityService $facilityService)
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'category' => $this->category,
            'city' => $this->city,
            'address' => $this->address,
            'description' => $this->description,
            'price_per_hour' => $this->price_per_hour,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail,
            'images' => $this->images,
        ];

        try {
            $facilityService->storeFacility($data, Auth::id());
            
            session()->flash('success', 'Fasilitas baru berhasil ditambahkan!');
            return redirect()->route('seller.facilities.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.seller.facility-create')->layout('layouts.app');
    }
}