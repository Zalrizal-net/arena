<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PublicFacilityController;
use App\Http\Controllers\Api\PublicScheduleController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\FacilityController;
use App\Http\Controllers\Api\MidtransCallbackController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\SellerTransactionController;
use App\Http\Controllers\Api\WalletApiController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Guest)
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/verify-otp', [AuthApiController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthApiController::class, 'resendOtp']);
Route::post('/forgot-password', [AuthApiController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthApiController::class, 'resetPassword']);

Route::post('/payments/callback', [MidtransCallbackController::class, 'handleCallback']);

Route::get('/facilities', [PublicFacilityController::class, 'index']);
Route::get('/facilities/{id}', [PublicFacilityController::class, 'show']);
Route::get('/facilities/{id}/reviews', [ReviewController::class, 'index']);
Route::get('/facilities/{id}/schedules', [PublicScheduleController::class, 'index']);

Route::prefix('shops')->group(function () {
    Route::get('/', [ShopController::class, 'index']);
    Route::get('/{slug}', [ShopController::class, 'show']);
    Route::get('/{slug}/facilities', [ShopController::class, 'facilities']);
});

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Membutuhkan Auth Token Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'data'   => $request->user()
        ], 200);
    });

    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index']);
        Route::post('/', [BookingController::class, 'store']);
        Route::get('/{id}', [BookingController::class, 'show']);
        Route::delete('/{id}', [BookingController::class, 'destroy']);
    });

    Route::get('/my-payments', [PaymentApiController::class, 'index']);
    Route::prefix('payments')->group(function () {
        Route::post('/create', [PaymentApiController::class, 'create']);
        Route::get('/{id}', [PaymentApiController::class, 'show']);
    });
    
    Route::post('/reviews', [ReviewController::class, 'store']);

    Route::prefix('seller')->group(function () {
        
        Route::get('/dashboard', [SellerTransactionController::class, 'getDashboard']);
        Route::get('/bookings', [SellerTransactionController::class, 'indexBookings']);
        Route::get('/bookings/{id}', [SellerTransactionController::class, 'showBooking']);

        Route::get('/facilities', [FacilityController::class, 'index']);
        Route::post('/facilities', [FacilityController::class, 'store']);
        Route::put('/facilities/{id}', [FacilityController::class, 'update']);
        Route::delete('/facilities/{id}', [FacilityController::class, 'destroy']);

        Route::prefix('schedules')->group(function () {
            Route::get('/{facilityId}', [PublicScheduleController::class, 'index']);
            Route::post('/', [ScheduleController::class, 'store']);
            Route::put('/{id}', [ScheduleController::class, 'update']);
            Route::delete('/{id}', [ScheduleController::class, 'destroy']);
        });

        Route::get('/wallet', [WalletApiController::class, 'index']);
        Route::post('/wallet/withdraw', [WalletApiController::class, 'requestWithdraw']);
    });
    
});