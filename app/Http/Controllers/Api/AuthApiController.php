<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

class AuthApiController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        try {
            $result = $this->authService->registerBuyer($request->only('name', 'email', 'phone', 'password'));
            return response()->json(['status' => 'success', 'message' => $result['message']], 201);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'Email atau password salah.'], 401);
        }

        if ($user->email_verified_at === null) {
            return response()->json(['status' => 'unverified', 'message' => 'Silakan verifikasi email Anda terlebih dahulu.'], 403);
        }

        $token = $this->authService->createSanctumToken($user, $request->device_name ?? 'mobile_device');

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil.',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|digits:6',
        ]);

        try {
            $this->authService->verifyOtp($request->email, $request->otp_code);
            
            $user = User::where('email', $request->email)->first();
            $token = $this->authService->createSanctumToken($user, 'mobile_device');

            return response()->json([
                'status' => 'success', 
                'message' => 'Verifikasi berhasil.',
                'token' => $token,
                'user' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Pengguna tidak ditemukan.'], 404);
        }

        try {
            $this->authService->generateAndSendOtp($user);
            return response()->json(['status' => 'success', 'message' => 'Kode OTP baru telah dikirim ke email Anda.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 429);
        }
    }

    public function forgotPassword(Request $request)
    {
        return $this->resendOtp($request);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $this->authService->resetPasswordWithOtp($request->email, $request->otp_code, $request->password);
            return response()->json(['status' => 'success', 'message' => 'Password berhasil diubah. Silakan login.'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function logout(Request $request)
    {
        $this->authService->logoutApi($request->user());
        
        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil.'
        ], 200);
    }
}