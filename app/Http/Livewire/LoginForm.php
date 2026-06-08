<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class LoginForm extends Component
{
    public $email;
    public $password;
    public $remember = false;

    public function login(AuthService $authService)
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];

        if ($authService->loginWeb($credentials, $this->remember)) {
            
            session()->regenerate();

            $role = Auth::user()->role;
            $defaultUrl = route('landing');

            if ($role === 'admin') {
                $defaultUrl = route('admin.dashboard');
            } elseif ($role === 'seller') {
                $defaultUrl = route('seller.dashboard');
            } elseif ($role === 'buyer') {
                $defaultUrl = route('buyer.dashboard');
            }

            return redirect()->intended($defaultUrl);
        }

        $this->addError('email', 'Kredensial salah! Email atau kata sandi tidak cocok.');
    }

    public function render()
    {
        return view('livewire.login-form')->layout('layouts.guest');
    }
}