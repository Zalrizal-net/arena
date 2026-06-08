<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Models\EmailVerification;

interface AuthRepositoryInterface
{
    public function createUser(array $data): User;
    public function findUserByEmail(string $email): ?User;
    public function createOtpRecord(int $userId, string $hashedOtp, string $expiredAt): EmailVerification;
    public function getLatestOtpRecord(int $userId): ?EmailVerification;
    public function markOtpAsVerified(int $otpId): void;
    public function markUserAsVerified(int $userId): void;
    public function updateUserPassword(int $userId, string $hashedPassword): void;
    public function countUnverifiedOtpsLastHour(int $userId): int;
}