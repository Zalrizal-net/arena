<?php

namespace App\Http\Livewire\Buyer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Profile extends Component
{
    public $name;
    public $email;
    public $phone;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        $user = User::find(Auth::id());
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        session()->flash('success', 'Profil Anda berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.buyer.profile')->layout('layouts.app');
    }
}