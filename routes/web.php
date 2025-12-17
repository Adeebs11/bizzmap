<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Landing page
Route::get("/", function () {    
    return view('landing');
});

// Routes untuk halaman statis
Route::get('/analytics', function () {
    return view('analytics');
});

Route::get('/menu', function () {
    return view('menu');
});

Route::get('/geo', function () {
    return view('geo');
});

Route::get('/demografi', function () {
    return view('demografi');
});

Route::get('/landing', function () {
    return view('landing');
});

// Routes untuk login, register, dan logout
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::post('/logout', [UserController::class, 'logout'])->name('logout');


Route::get('/admin-test', function () {
    return 'Admin OK';
})->middleware(['auth', 'admin']);