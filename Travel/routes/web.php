<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;


Route::get('/', [HomeController::class, 'index'])->name("home");
Route::get('/about', [HomeController::class, 'about'])->name("about");
Route::get('/service', [HomeController::class, 'service'])->name("service");
Route::get('/tour', [HomeController::class, 'tour'])->name("tour");
Route::get('/contact', [HomeController::class, 'contact'])->name("contact");
//page
Route::get('/blog', [HomeController::class, 'blog'])->name("blog");
Route::get('/single', [HomeController::class, 'single'])->name("single");
Route::get('/destination', [HomeController::class, 'destination'])->name("destination");
Route::get('/guide', [HomeController::class, 'guide'])->name("guide");
Route::get('/testimonial', [HomeController::class, 'testimonial'])->name("testimonial");
//Quản Lý Tour
Route::get('/admin', [AdminController::class, 'index'])->name('tours.index');
Route::get('/admin/create', [AdminController::class, 'create'])->name('tours.create');
Route::post('/admin', [AdminController::class, 'store'])->name('tours.store');
Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('tours.edit');
Route::put('/admin/{id}', [AdminController::class, 'update'])->name('tours.update');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('tours.destroy');
Route::get('/admin/search', [AdminController::class, 'search'])->name('tours.search');

