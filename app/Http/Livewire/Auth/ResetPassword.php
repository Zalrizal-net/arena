<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Services\AuthService;
use Exception;

class ResetPassword extends Component
{
    public $email;
    public $otp_code;
    public $password;
    public $password_confirmation;

    protected $queryString = ['email'];

    public function mount()
    {
        if (!$this->email) {
            return redirect()->route('forgot-password');
        }
    }

    public function resetPassword(AuthService $authService)
    {
        $this->validate([
            'otp_code' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $authService->resetPasswordWithOtp($this->email, $this->otp_code, $this->password);
            session()->flash('message', 'Password berhasil diubah! Silakan login dengan password baru.');
            return redirect()->route('login');
        } catch (Exception $e) {
            $this->addError('otp_code', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password')->layout('layouts.guest');
    }
}