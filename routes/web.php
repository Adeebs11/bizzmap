<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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

Route::post('/logout', [UserController::class, 'logout'])->name('logout');


Route::get('/admin-test', function () {
    return 'Admin OK';
})->middleware(['auth', 'admin']);

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pending', [AdminController::class, 'pending'])->name('admin.pending');
    Route::post('/pending/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::patch('/users/{id}/role', [AdminController::class, 'updateUserRole'])
    ->name('admin.users.role');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');


});