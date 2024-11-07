<?php

use App\Http\Controllers\Auth\OTPVefificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\VerifyOTPController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TourController;

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
Route::post('/create-post', [PostController::class, 'storePost'])->name('store.post');
Route::post('/blog/{id}/toggle-like', [PostController::class, 'toggleLike'])->name('blog.toggleLike');
Route::post('/posts/{postId}/comment', [PostController::class, 'storeComment'])->name('comment.store');
Route::post('/comments/{commentId}/reply', [PostController::class, 'storeReply'])->name('reply.store');
Route::delete('/comments/{id}', [PostController::class, 'deleteComment']);
Route::delete('/comments/reply/{id}', [PostController::class, 'deleteReply']);
Route::put('/comments/{id}', [PostController::class, 'updateComment']);
Route::put('/comments/reply/{id}', [PostController::class, 'updateReply']);

