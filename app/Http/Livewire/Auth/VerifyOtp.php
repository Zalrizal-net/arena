<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Services\AuthService;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Exception;

class VerifyOtp extends Component
{
    public $email;
    public $otp_code;

    protected $queryString = ['email'];

    public function mount()
    {
        if (!$this->email) {
            return redirect()->route('login');
        }
    }

    public function verify(AuthService $authService, AuthRepositoryInterface $authRepository)
    {
        $this->validate([
            'otp_code' => 'required|digits:6',
        ]);

        try {
            $authService->verifyOtp($this->email, $this->otp_code);
            
            // Auto login setelah sukses verifikasi
            $user = $authRepository->findUserByEmail($this->email);
            Auth::login($user);

            return redirect()->route('landing');
        } catch (Exception $e) {
            $this->addError('otp_code', $e->getMessage());
        }
    }

    public function resend(AuthService $authService, AuthRepositoryInterface $authRepository)
    {
        $user = $authRepository->findUserByEmail($this->email);
        
        if ($user) {
            try {
                $authService->generateAndSendOtp($user);
                session()->flash('message', 'Kode OTP baru telah dikirim ke email Anda.');
            } catch (Exception $e) {
                session()->flash('error', $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.auth.verify-otp')->layout('layouts.guest');
    }
}