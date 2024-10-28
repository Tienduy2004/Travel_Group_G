<?php

use App\Http\Controllers\Auth\OTPVefificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\VerifyOTPController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PromotionController;



Route::get('/', [HomeController::class, 'index'])->name("home");
Route::get('/about', [HomeController::class, 'about'])->name("about");
Route::get('/service', [HomeController::class, 'service'])->name("service");
Route::get('/tours', [HomeController::class, 'tour'])->name("tour");
Route::get('/contact', [HomeController::class, 'contact'])->name("contact");


//page
// Route::get('/blog', [HomeController::class, 'blog'])->name("blog");
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::get('/verify-otp', [VerifyOTPController::class, 'showVerifyForm'])->middleware('auth')->name('otp.verify');
Route::post('/verify-otp', [VerifyOTPController::class, 'verify'])->middleware('auth')->name('otp.verify.post');
Route::post('/otp/resend', [OTPVefificationController::class, 'resend'])->name('otp.resend');

//tour
Route::get('/tours/{id}', [TourController::class, 'show'])->name('tours.show');


//Post
Route::get('/blog', [PostController::class, 'index'])->name('blog');
Route::get('/blog/{id}', [PostController::class, 'showBlog'])->name('blog.show');
Route::get('/category/{id}', [PostController::class, 'getPostbyCategory'])->name('category.posts');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/create', [PostController::class, 'create_post'])->name('create.post');





//quản lý tour
// Route cho trang chủ admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.trangchu');

// Route cho quản lý tour
Route::get('/admin/tours', [AdminController::class, 'trangchu'])->name('tours.trangchu');
Route::get('/admin/tours/create', [AdminController::class, 'create'])->name('tours.create');
Route::post('/admin/tours', [AdminController::class, 'store'])->name('tours.store');
Route::get('/admin/tours/{id}/edit', [AdminController::class, 'edit'])->name('tours.edit');
Route::put('/admin/tours/{id}', [AdminController::class, 'update'])->name('tours.update');
Route::delete('/admin/tours/{id}', [AdminController::class, 'destroy'])->name('tours.destroy');
Route::get('/admin/tours/search', [AdminController::class, 'search'])->name('tours.search');

// Route cho khuyến mãi
Route::get('/admin/promotions/create', [PromotionController::class, 'create'])->name('promotions.create');
Route::post('/admin/promotions', [PromotionController::class, 'store'])->name('promotions.store');
Route::get('/admin/promotions', [PromotionController::class, 'index'])->name('promotions.index');
Route::get('/admin/promotions/{promotion}/edit', [PromotionController::class, 'edit'])->name('promotions.edit');
Route::put('/admin/promotions/{promotion}', [PromotionController::class, 'update'])->name('promotions.update');
Route::delete('/admin/promotions/{promotion}', [PromotionController::class, 'destroy'])->name('promotions.destroy');


// Route cho quản lý Blog
use App\Http\Controllers\BlogManagementController;
Route::prefix('managementblog')->group(function () {
    Route::get('/', [BlogManagementController::class, 'index'])->name('admin.blog.index');
    Route::get('/create', [BlogManagementController::class, 'create'])->name('admin.blog.create');
    Route::post('/', [BlogManagementController::class, 'store'])->name('admin.blog.store');
    Route::get('/{id}/edit', [BlogManagementController::class, 'edit'])->name('admin.blog.edit');
    Route::put('/{id}', [BlogManagementController::class, 'update'])->name('admin.blog.update');
    Route::delete('/{id}', [BlogManagementController::class, 'destroy'])->name('admin.blog.destroy');
});

