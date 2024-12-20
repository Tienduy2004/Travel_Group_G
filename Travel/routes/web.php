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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PostController;
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









// Quản lý tour

Route::get('/admin', [AdminController::class, 'trangchu'])->name('admin.trangchu');

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
Route::post('/apply-promotion', [PromotionController::class, 'applyPromotion']);
Route::get('/promotions/danhsachkhuyenmai', [PromotionController::class, 'danhsachkhuyenmai'])->name('promotions.danhsachkhuyenmai');



// Route cho trang đăng nhập admin

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Route cho trang đăng ký admin
Route::get('/admin/register', [AdminAuthController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

//phan quyèn
Route::prefix('admin')->group(function () {
    Route::get('users', [AdminUserController::class, 'index'])->name('admin.users.index'); // Danh sách người dùng
    Route::get('users/{id}/edit', [AdminUserController::class, 'editRole'])->name('admin.users.edit'); // Chỉnh sửa quyền
    Route::put('users/{id}/update', [AdminUserController::class, 'updateRole'])->name('admin.users.update'); // Cập nhật quyền
});







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
Route::get('/notifications', [PostController::class, 'getNotifications']);
Route::delete('/blog/{id}', [PostController::class, 'destroyBlog'])->name('blog.destroyBlog');
Route::get('/blog/{id}/edit', [PostController::class, 'editBlog'])->name('blog.editBlog');
Route::put('/blog/update/{id}', [PostController::class, 'updateBlog'])->name('blog.updateBlog');
Route::post('/blog/{post}/rating', [PostController::class, 'rate'])->name('post.rating');
Route::post('/blog/{postId}/bookmark', [PostController::class, 'storeBookmark'])->name('blog.bookmark');
Route::get('/bookmarks', [PostController::class, 'getBookmark'])->name('bookmarks');
Route::delete('/bookmarks/{blog}', [PostController::class, 'removeBookmark'])->name('bookmarks.remove');

// Quản lý danh mục blog
use App\Http\Controllers\CategoryManagementController;

Route::prefix('admin')->group(function () {
    Route::get('category', [CategoryManagementController::class, 'index'])->name('admin.category.index');
    Route::get('category/create', [CategoryManagementController::class, 'create'])->name('admin.category.create');
    Route::post('category', [CategoryManagementController::class, 'store'])->name('admin.category.store');
    Route::get('category/{id}/edit', [CategoryManagementController::class, 'edit'])->name('admin.category.edit');
    Route::put('category/{id}', [CategoryManagementController::class, 'update'])->name('admin.category.update');
    Route::delete('category/{id}', [CategoryManagementController::class, 'destroy'])->name('admin.category.destroy');
});
// Route cho quản lý Blog
use App\Http\Controllers\BlogManagementController;
use App\Livewire\Chat\ChatList;

Route::prefix('managementblog')->group(function () {
    Route::get('/', [BlogManagementController::class, 'index'])->name('admin.blog.index');  // Danh sách blog
    Route::get('/create', [BlogManagementController::class, 'create'])->name('admin.blog.create'); // Form tạo bài viết
    Route::post('/', [BlogManagementController::class, 'store'])->name('admin.blog.store'); // Lưu bài viết mới
    Route::get('/{id}/edit', [BlogManagementController::class, 'edit'])->name('admin.blog.edit'); // Form chỉnh sửa bài viết
    Route::put('/{id}', [BlogManagementController::class, 'update'])->name('admin.blog.update'); // Cập nhật bài viết
    Route::delete('/{id}', [BlogManagementController::class, 'destroy'])->name('admin.blog.destroy'); // Xóa bài viết
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/{id}/update-cover', [ProfileController::class, 'updateCover'])->name('profile.update.cover');
    Route::post('/profile/{id}/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');

    Route::put('/profile/{id}/update-details', [ProfileController::class, 'updateDetails'])->name('profile.update.details');
});

Route::middleware('auth')->group(function () {

    Route::get('/chat', Index::class)->name('chat.index');
    Route::get('/chat/{query}', Chat::class)->name('chat');
    Route::post('/message', [ChatController::class, 'sendMessage'])->name('message.send');
    Route::get('/users', Users::class)->name('users');
    // Route xóa chat
    Route::delete('/chat/{chat}', [ChatController::class, 'deleteByUser'])->name('chat.destroy');
});

Route::middleware('auth')->group(function () {

    Route::get('/friends', FriendsIndex::class)->name('friends.index');
    Route::post('/friends/add', [FriendController::class, 'add'])->name('friends.add');
    Route::post('/friends/cancel', [FriendController::class, 'cancel'])->name('friends.cancel');
    Route::post('/friends/cancelInvitation', [FriendController::class, 'cancelInvitation'])->name('friends.cancelInvitation');
    Route::post('/friends/accept', [FriendController::class, 'accept'])->name('friends.accept');
});

Route::middleware('auth')->group(function () {

    Route::get('/home', HomeIndex::class)->name('home.index');
});
