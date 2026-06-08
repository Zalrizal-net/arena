<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Services\AuthService;
use App\Repositories\Contracts\AuthRepositoryInterface;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login(AuthService $authService, AuthRepositoryInterface $authRepository)
    {
        $this->validate();

        $user = $authRepository->findUserByEmail($this->email);

        if ($user && $user->email_verified_at === null) {
            return redirect()->route('verify-otp', ['email' => $this->email]);
        }

        if ($authService->loginWeb(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            return redirect()->intended('/');
        }

        $this->addError('email', 'Email atau kata sandi salah.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
