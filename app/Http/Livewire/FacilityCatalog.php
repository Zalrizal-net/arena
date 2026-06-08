<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Facility;

class FacilityCatalog extends Component
{
    use WithPagination;

    // Properti filter
    public $search = '';
    public $city = '';
    public $category = '';

    // AJAIBNYA LIVEWIRE: Ini akan otomatis mengubah properti di atas menjadi URL Parameter
    protected $queryString = [
        'search' => ['except' => ''],
        'city' => ['except' => ''],
       
    ];

    // Reset halaman ke 1 setiap kali user mengubah filter
    public function updatingSearch() { $this->resetPage(); }
    public function updatingCity() { $this->resetPage(); }
  

    public function render()
    {
        // Menggunakan Eloquent 'when' sebagai ganti raw SQL IF/WHERE yang berantakan
        $facilities = Facility::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->city, function ($query) {
                $query->where('city', $this->city);
            })
           
            ->latest()
            ->paginate(12); // Menampilkan 12 data per halaman

        return view('livewire.facility-catalog', [
            'facilities' => $facilities
        ])->layout('layouts.guest'); // Pastikan layout sesuai
    }
}