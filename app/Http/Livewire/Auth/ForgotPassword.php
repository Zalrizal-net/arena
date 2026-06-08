<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Services\AuthService;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Exception;

class ForgotPassword extends Component
{
    public $email;

    public function sendOtp(AuthService $authService, AuthRepositoryInterface $authRepository)
    {
        $this->validate(['email' => 'required|email']);

        $user = $authRepository->findUserByEmail($this->email);

        if (!$user) {
            $this->addError('email', 'Email tidak ditemukan di sistem kami.');
            return;
        }

        try {
            $authService->generateAndSendOtp($user);
            return redirect()->route('reset-password', ['email' => $this->email]);
        } catch (Exception $e) {
            $this->addError('email', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('layouts.guest');
    }
}