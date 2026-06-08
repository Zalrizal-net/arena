<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        // Me-render view dan secara eksplisit menggunakan layout admin
        return view('livewire.admin-dashboard')
            ->layout('layouts.admin');
    }
}