<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\EmailVerification;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Carbon\Carbon;

class AuthRepository implements AuthRepositoryInterface
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function findUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function createOtpRecord(int $userId, string $hashedOtp, string $expiredAt): EmailVerification
    {
        // Invalidate OTP sebelumnya yang belum dipakai agar tidak menumpuk
        EmailVerification::where('user_id', $userId)
            ->whereNull('verified_at')
            ->update(['expired_at' => Carbon::now()]);

        return EmailVerification::create([
            'user_id' => $userId,
            'otp_code' => $hashedOtp,
            'expired_at' => $expiredAt,
        ]);
    }

    public function getLatestOtpRecord(int $userId): ?EmailVerification
    {
        return EmailVerification::where('user_id', $userId)
            ->latest()
            ->first();
    }

    public function markOtpAsVerified(int $otpId): void
    {
        EmailVerification::where('id', $otpId)->update([
            'verified_at' => Carbon::now()
        ]);
    }

    public function markUserAsVerified(int $userId): void
    {
        User::where('id', $userId)->update([
            'email_verified_at' => Carbon::now()
        ]);
    }

    public function updateUserPassword(int $userId, string $hashedPassword): void
    {
        User::where('id', $userId)->update([
            'password' => $hashedPassword
        ]);
    }

    public function countUnverifiedOtpsLastHour(int $userId): int
    {
        return EmailVerification::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subHour())
            ->whereNull('verified_at')
            ->count();
    }
}