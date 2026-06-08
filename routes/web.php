<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Livewire\LandingPage;
use App\Http\Livewire\FacilityCatalog;
use App\Http\Livewire\FacilityDetail;
use App\Http\Livewire\Shop\ShopDetail;
use App\Http\Livewire\BookingDetail;
use App\Http\Livewire\BookingCheckout;

use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\VerifyOtp;
use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Livewire\Chat\ChatList;
use App\Http\Livewire\Chat\ChatRoom;
use App\Http\Controllers\ChatController;

use App\Http\Livewire\LoginForm;
use App\Http\Livewire\RegisterForm;
use App\Services\AuthService;

use App\Http\Livewire\AdminDashboard;
use App\Http\Livewire\Seller\SellerDashboard;

use App\Http\Livewire\Buyer\BuyerDashboard;
use App\Http\Livewire\Buyer\Cart;
use App\Http\Livewire\Buyer\Profile;
use App\Http\Livewire\Buyer\BookingHistory;
use App\Http\Livewire\Buyer\NotificationList;
use App\Http\Livewire\Buyer\ReviewForm;

use App\Http\Livewire\Seller\FacilityList;
use App\Http\Livewire\Seller\FacilityCreate;
use App\Http\Livewire\Seller\FacilityEdit;
use App\Http\Livewire\Seller\ScheduleList;
use App\Http\Livewire\Seller\ScheduleForm; 
use App\Http\Livewire\Seller\BookingList;
use App\Http\Livewire\Seller\SellerBookingDetail;
use App\Http\Livewire\Seller\IncomeDashboard;
use App\Http\Livewire\Seller\WalletDashboard;
use App\Http\Livewire\Seller\WithdrawRequest;


Route::get('/', LandingPage::class)->name('landing');
    Route::get('/fasilitas', FacilityCatalog::class)->name('facilities.index');
    Route::get('/facilities/{slug}', FacilityDetail::class)->name('facility.show');
    Route::get('/shops/{slug}', ShopDetail::class)->name('shop.detail');
    // Route::get('/login', LoginForm::class)->name('login');
    // Route::get('/register', RegisterForm::class)->name('register');

Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
    Route::get('/verify-otp', VerifyOtp::class)->name('verify-otp');
    Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
    Route::get('/reset-password', ResetPassword::class)->name('reset-password');

    // Google OAuth Routes
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
});

// Rute Terproteksi Autentikasi 
Route::middleware('auth')->group(function () {
    Route::post('/logout', function (Request $request, AuthService $authService) {
        $authService->logoutWeb($request);
        return redirect()->route('login');
    })->name('logout');

    Route::get('/chats', ChatList::class)->name('chat.list');
    Route::get('/chats/{room}', ChatRoom::class)->name('chat.room');
    Route::post('/chats/start/{facility}', [ChatController::class, 'startChat'])->name('chat.start');

    // Kelompok Rute khusus Admin
    Route::middleware('role.admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    });

    // Kelompok Rute khusus Seller
    Route::middleware('role.seller')->prefix('seller')->group(function () {
        Route::get('/dashboard', SellerDashboard::class)->name('seller.dashboard');

        // Rute Manajemen Fasilitas Seller
        Route::get('/facilities', FacilityList::class)->name('seller.facilities.index');
        Route::get('/facilities/create',FacilityCreate::class)->name('seller.facilities.create'); 
        Route::get('/facilities/{id}/edit', FacilityEdit::class)->name('seller.facilities.edit');
        // Rute Manajemen Jadwal Fasilitas (RUTE BARU)
        Route::get('/facilities/{facilityId}/schedules', ScheduleList::class)->name('seller.schedules.index');
        Route::get('/facilities/{facilityId}/schedules/create', ScheduleForm::class)->name('seller.schedules.create');
        Route::get('/facilities/{facilityId}/schedules/{scheduleId}/edit', ScheduleForm::class)->name('seller.schedules.edit');

        Route::get('/bookings', BookingList::class)->name('bookings.index');
        Route::get('/bookings/{id}', SellerBookingDetail::class)->name('bookings.show');
        Route::get('/wallet', WalletDashboard::class)->name('wallet.index');
        Route::get('/wallet/withdraw', WithdrawRequest::class)->name('wallet.withdraw');
       // Dashboard Pendapatan
        Route::get('/income', IncomeDashboard::class)->name('income');
    });


    Route::middleware(['auth', 'role.buyer'])->prefix('buyer')->group(function () {
         Route::get('/dashboard', BuyerDashboard::class)->name('buyer.dashboard');
         Route::get('/cart',Cart::class)->name('buyer.cart');
         Route::get('/profile', Profile::class)->name('buyer.profile');
         Route::get('/buyer/bookings', BookingHistory::class)->name('booking.history');

        Route::get('/checkout', BookingCheckout::class)->name('booking.checkout');
       
        Route::get('/my-bookings/{id}',BookingDetail::class)->name('booking.show');
        Route::get('/buyer/notifications', NotificationList::class)->name('buyer.notifications');
        Route::get('/review/create/{bookingId}', ReviewForm::class)->name('buyer.review.create');

        
     
        
    });
});