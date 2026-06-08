<?php

namespace App\Http\Livewire\Seller;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\FacilityService;
use Illuminate\Support\Facades\Auth;

class FacilityEdit extends Component
{
    use WithFileUploads;

    public $facilityId;
    public $name;
    public $category;
    public $city;
    public $address;
    public $description;
    public $price_per_hour;
    public $status;
    
    // Properti untuk menyimpan gambar yang baru diunggah
    public $newThumbnail;
    public $newImages = []; 

    // Properti untuk menampilkan gambar lama
    public $oldThumbnail;
    public $oldImages = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'address' => 'required|string',
        'description' => 'required|string',
        'price_per_hour' => 'required|numeric|min:0',
        'status' => 'required|in:active,inactive',
        'newThumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'newImages.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ];

    protected $messages = [
        'required' => 'Kolom :attribute wajib diisi.',
        'numeric' => 'Kolom :attribute harus berupa angka.',
        'image' => 'File harus berupa gambar.',
        'max' => 'Ukuran maksimal file adalah 2MB.',
    ];

    public function mount($id, FacilityService $facilityService)
    {
        try {
            $facility = $facilityService->getFacilityDetail($id, Auth::id());
            
            $this->facilityId = $facility->id;
            $this->name = $facility->name;
            $this->category = $facility->category;
            $this->city = $facility->city;
            $this->address = $facility->address;
            $this->description = $facility->description;
            $this->price_per_hour = $facility->price_per_hour;
            $this->status = $facility->status;
            
            $this->oldThumbnail = $facility->thumbnail;
            $this->oldImages = $facility->images->pluck('image_path')->toArray();
        } catch (\Exception $e) {
            session()->flash('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
            return redirect()->route('seller.facilities.index');
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function update(FacilityService $facilityService)
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
        ];

        if ($this->newThumbnail) {
            $data['thumbnail'] = $this->newThumbnail;
        }

        if (!empty($this->newImages)) {
            $data['images'] = $this->newImages;
        }

        try {
            $facilityService->updateFacility($this->facilityId, $data, Auth::id());
            
            session()->flash('success', 'Fasilitas berhasil diperbarui!');
            return redirect()->route('seller.facilities.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.seller.facility-edit')->layout('layouts.app');
    }
}