<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class AuthService
{
    protected $userRepository;
    protected $authRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AuthRepositoryInterface $authRepository
    ) {
        $this->userRepository = $userRepository;
        $this->authRepository = $authRepository;
    }

    public function registerUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        
        if (!isset($data['role'])) {
            $data['role'] = 'buyer'; 
        }

        return $this->userRepository->create($data);
    }

    public function loginWeb(array $credentials, bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    public function logoutWeb(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function createSanctumToken(User $user, string $deviceName = 'mobile_device'): string
    {
        return $user->createToken($deviceName)->plainTextToken;
    }

    public function logoutApi(User $user): void
    {
        $user->tokens()->delete();
    }

    public function registerBuyer(array $data): array
    {
        $existingUser = $this->authRepository->findUserByEmail($data['email']);
        
        if ($existingUser) {
            throw new Exception('Email sudah terdaftar.');
        }

        $user = $this->authRepository->createUser([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => 'buyer',
        ]);

        $this->generateAndSendOtp($user);

        return [
            'user' => $user, 
            'message' => 'Registrasi berhasil. Silakan cek email Anda untuk kode OTP.'
        ];
    }

    public function generateAndSendOtp(User $user): void
    {
        $requestsLastHour = $this->authRepository->countUnverifiedOtpsLastHour($user->id);
        
        if ($requestsLastHour >= 5) {
            throw new Exception('Terlalu banyak permintaan OTP. Silakan coba lagi nanti.');
        }

        $otpPlain = (string) random_int(100000, 999999);
        $expiredAt = Carbon::now()->addMinutes(10);

        $this->authRepository->createOtpRecord($user->id, Hash::make($otpPlain), $expiredAt);

        Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($otpPlain, $user->name));
    }

    public function verifyOtp(string $email, string $otpPlain): bool
    {
        $user = $this->authRepository->findUserByEmail($email);
        
        if (!$user) {
            throw new Exception('Pengguna tidak ditemukan.');
        }

        $latestOtp = $this->authRepository->getLatestOtpRecord($user->id);

        if (!$latestOtp) {
            throw new Exception('Kode OTP tidak ditemukan atau belum dibuat.');
        }

        if ($latestOtp->verified_at !== null) {
            throw new Exception('Kode OTP ini sudah pernah digunakan.');
        }

        if (Carbon::now()->greaterThan($latestOtp->expired_at)) {
            throw new Exception('Kode OTP sudah kedaluwarsa. Silakan minta kode baru.');
        }

        if (!Hash::check($otpPlain, $latestOtp->otp_code)) {
            throw new Exception('Kode OTP yang Anda masukkan salah.');
        }

        $this->authRepository->markOtpAsVerified($latestOtp->id);
        
        if ($user->email_verified_at === null) {
            $this->authRepository->markUserAsVerified($user->id);
        }

        return true;
    }

    public function handleGoogleCallback(): User
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = $this->authRepository->findUserByEmail($googleUser->getEmail());

        if (!$user) {
            $user = $this->authRepository->createUser([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'phone' => '000000000000',
                'password' => Hash::make(Str::random(24)),
                'role' => 'buyer',
            ]);
            
            $this->authRepository->markUserAsVerified($user->id);
        }

        return $user;
    }

    public function resetPasswordWithOtp(string $email, string $otpPlain, string $newPassword): bool
    {
        $this->verifyOtp($email, $otpPlain);
        
        $user = $this->authRepository->findUserByEmail($email);
        $this->authRepository->updateUserPassword($user->id, Hash::make($newPassword));

        return true;
    }
}