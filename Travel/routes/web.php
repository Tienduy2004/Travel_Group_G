<?php

use App\Http\Controllers\Auth\OTPVefificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\VerifyOTPController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TourController;
use App\Livewire\Chat\Chat;
use App\Livewire\Chat\Index;
use App\Livewire\Friends\AllFriends;
use App\Livewire\Friends\FriendRequests;
use App\Livewire\Friends\Index as FriendsIndex;
use App\Livewire\Home\Index as HomeIndex;
use App\Livewire\Users;



Route::get('/', [HomeController::class, 'index'])->name("home");
Route::get('/about', [HomeController::class, 'about'])->name("about");
Route::get('/service', [HomeController::class, 'service'])->name("service");
Route::get('/tours', [HomeController::class, 'tour'])->name("tour");
Route::get('/search-results', [TourController::class, 'searchResults'])->name('search.results');
Route::get('/search-suggestions', [HomeController::class, 'searchSuggestions']);
Route::get('/contact', [HomeController::class, 'contact'])->name("contact");


//page
Route::get('/blog', [HomeController::class, 'blog'])->name("blog");
Route::get('/single', [HomeController::class, 'single'])->name("single");
Route::get('/destination', [HomeController::class, 'destination'])->name("destination");
Route::get('/guide', [HomeController::class, 'guide'])->name("guide");
Route::get('/testimonial', [HomeController::class, 'testimonial'])->name("testimonial");
//login


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
Route::get('/verify-otp', [VerifyOTPController::class, 'showVerifyForm'])->middleware('auth')->name('otp.verify');
Route::post('/verify-otp', [VerifyOTPController::class, 'verify'])->middleware('auth')->name('otp.verify.post');
Route::post('/otp/resend', [OTPVefificationController::class, 'resend'])->name('otp.resend');

//tour
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/{id}', [TourController::class, 'showBookingPage'])->name('tours.booking');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/booking-payment/{bookingCode}', [PaymentController::class, 'showPaymentForm'])->name('booking.payment');
    Route::post('/payment', [PaymentController::class, 'createPaymentLink'])->name('payment.create');
    Route::post('/booking/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/payment/cancel', [PaymentController::class, 'cancelPaymentLink']);
    Route::get('/payment/success', [PaymentController::class, 'successPaymentLink']);
    Route::get('/encrypt-id/{id}', [TourController::class, 'encryptId']);
});
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/{id}/update-cover', [ProfileController::class, 'updateCover'])->name('profile.update.cover');
    Route::post('/profile/{id}/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');
   
    // Route::post('/messages', [FriendController::class, 'cancel'])->name('messages.send');
   

});

Route::middleware('auth')->group(function (){

    Route::get('/chat',Index::class)->name('chat.index');
    Route::get('/chat/{query}',Chat::class)->name('chat');
    Route::post('/message', [ChatController::class, 'sendMessage'])->name('message.send');
    Route::get('/users',Users::class)->name('users');
    

});

Route::middleware('auth')->group(function (){

    Route::get('/friends', FriendsIndex::class)->name('friends.index');
    Route::post('/friends/add', [FriendController::class, 'add'])->name('friends.add');
    Route::post('/friends/cancel', [FriendController::class, 'cancel'])->name('friends.cancel');
    Route::post('/friends/cancelInvitation', [FriendController::class, 'cancelInvitation'])->name('friends.cancelInvitation');
    Route::post('/friends/accept', [FriendController::class, 'accept'])->name('friends.accept');
});

Route::middleware('auth')->group(function (){

    Route::get('/home', HomeIndex::class)->name('home.index');
});
