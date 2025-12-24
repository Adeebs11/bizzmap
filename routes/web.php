<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocationController;


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


Route::get('/landing', function () {
    return view('landing');
});

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
    Route::patch('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.role');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    
    Route::post('/pending/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');
    Route::post('/admin/pending/bulk-approve', [AdminController::class, 'bulkApprove'])->name('admin.pending.bulkApprove');
    Route::post('/admin/pending/bulk-reject', [AdminController::class, 'bulkReject'])->name('admin.pending.bulkReject');

    Route::get('/locations', [AdminController::class, 'locations'])->name('admin.locations');
    Route::get('/locations/{id}/edit', [AdminController::class, 'editLocation'])->name('admin.locations.edit');
    Route::put('/locations/{id}', [AdminController::class, 'updateLocation'])->name('admin.locations.update');
    Route::delete('/locations/{id}', [AdminController::class, 'deleteLocation'])->name('admin.locations.delete');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/demografi', [LocationController::class, 'demografi'])->name('demografi');
    Route::get('/locations/approved', [LocationController::class, 'approved'])->name('locations.approved');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::post('/locations/import', [LocationController::class, 'import'])->name('locations.import');
});
