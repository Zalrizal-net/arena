<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class RegisterForm extends Component
{
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    public $role = 'buyer';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'phone' => 'required|string|max:20|unique:users,phone',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:buyer,seller',
    ];

    public function selectRole(string $selectedRole)
    {
        $this->role = $selectedRole;
    }

    public function register(AuthService $authService)
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'role' => $this->role,
        ];

        $user = $authService->registerUser($data);
        Auth::login($user);

        return match ($user->role) {
            'seller' => redirect()->route('seller.dashboard'),
            'buyer' => redirect()->route('buyer.dashboard'),
            default => redirect()->route('login'),
        };
    }

    public function render()
    {
        // PERBAIKAN: Arahkan ke layout guest
        return view('livewire.register-form')->layout('layouts.guest');
    }
}