<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Services\AuthService;
use Exception;

class Register extends Component
{
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'password' => 'required|min:8|confirmed',
    ];

    public function register(AuthService $authService)
    {
        $this->validate();

        try {
            $authService->registerBuyer([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => $this->password,
            ]);
            
            return redirect()->route('verify-otp', ['email' => $this->email]);
        } catch (Exception $e) {
            $this->addError('email', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.guest');
    }
}