<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Thêm dashboard để tránh 404 sau đăng nhập Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Công khai: chỉ xem danh sách & chi tiết
Route::resource('articles', ArticleController::class)->only(['index', 'show']);

// Các thao tác còn lại: yêu cầu đăng nhập (Breeze cung cấp login/register/logout)
Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class)->only(['create','store','edit','update','destroy']);
});

// Khu vực quản trị: đầy đủ CRUD, yêu cầu đăng nhập + admin (từ BT3)
Route::prefix('admin')->as('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('articles', ArticleController::class);
});

// Demo throttle trên web: 5 requests/phút
Route::get('/demo-rate', function () {
    return response()->json(['status' => 'ok', 'time' => now()->toDateTimeString()]);
})->middleware('throttle:5,1');

// Nạp các route xác thực của Breeze (login, register, password reset, ...)
require __DIR__.'/auth.php';
