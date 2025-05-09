<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\AdminController;

// =======================
// Public Auth Routes
// =======================
Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::post('/admin/login', [UsersController::class, 'adminLogin']); // Optional: Separate login logic if needed

// =======================
// Customer Public Features
// =======================
Route::get('/services', [CustomerController::class, 'listServices']);

// =======================
// Customer Protected Routes (JWT)
// =======================
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [UsersController::class, 'logout']);
    Route::post('/book', [CustomerController::class, 'bookService']);
    Route::get('/booking/{id}', [CustomerController::class, 'bookingStatus']);
});

// =======================
// Admin Protected Routes (JWT + Role)
// =======================
Route::middleware(['auth:api', 'role:admin'])->prefix('admin')->group(function () {
    // Services
    Route::get('/services', [AdminController::class, 'listServices']);
    Route::post('/services', [AdminController::class, 'createService']);
    Route::get('/services/{id}', [AdminController::class, 'getService']);
    Route::put('/services/{id}', [AdminController::class, 'updateService']);
    Route::delete('/services/{id}', [AdminController::class, 'deleteService']);

    // Bookings
    Route::get('/bookings', [AdminController::class, 'listBookings']);
});
