<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminFinanceController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Http\Controllers\Admin\AdminPOSController;
use App\Http\Controllers\Admin\AdminFaceVerificationController;
use App\Http\Controllers\Admin\AdminEmployeeController;
use App\Http\Controllers\Admin\AdminCarouselController;
use App\Models\CarouselItem;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    $carouselItems = CarouselItem::all();
    return view('welcome', compact('carouselItems'));
});

// Custom Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('customer.dashboard');
})->middleware(['auth'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Customer routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/customer/dashboard', [CustomerBookingController::class, 'index'])->name('customer.dashboard');
    Route::get('/bookings/create', [CustomerBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [CustomerBookingController::class, 'store'])->name('bookings.store');
    
    // Chat Customer
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
});

// Shared Chat Ajax routes
Route::middleware(['auth'])->group(function () {
    Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/fetch/{otherUserId}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
});

// Admin Verification Routes (Require auth + role but NOT yet face verified)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/verify-face', [AdminFaceVerificationController::class, 'show'])->name('verify-face');
    Route::post('/verify-face', [AdminFaceVerificationController::class, 'verify'])->name('verify-face.post');
});

// Admin Console Routes (Protected by full face verification)
Route::middleware(['auth', 'role:admin', 'admin.face.verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Bookings CRUD & actions
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [AdminBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [AdminBookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/edit', [AdminBookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
    Route::post('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/pay', [AdminBookingController::class, 'markAsPaid'])->name('bookings.pay');
    Route::post('/bookings/{booking}/dp', [AdminBookingController::class, 'markAsDp'])->name('bookings.dp');

    // Finances CRUD
    Route::resource('finances', AdminFinanceController::class)->except(['show']);

    // Inventories CRUD & stock adjust
    Route::get('/inventories', [AdminInventoryController::class, 'index'])->name('inventories.index');
    Route::post('/inventories', [AdminInventoryController::class, 'store'])->name('inventories.store');
    Route::get('/inventories/{inventory}/edit', [AdminInventoryController::class, 'edit'])->name('inventories.edit');
    Route::put('/inventories/{inventory}', [AdminInventoryController::class, 'update'])->name('inventories.update');
    Route::delete('/inventories/{inventory}', [AdminInventoryController::class, 'destroy'])->name('inventories.destroy');
    Route::post('/inventories/{inventory}/adjust', [AdminInventoryController::class, 'adjustStock'])->name('inventories.adjust');

    // Employee CRUD
    Route::get('/employees', [AdminEmployeeController::class, 'index'])->name('employees.index');
    Route::post('/employees', [AdminEmployeeController::class, 'store'])->name('employees.store');
    Route::post('/employees/detect-face', [AdminEmployeeController::class, 'detectFace'])->name('employees.detect-face');
    Route::get('/employees/{employee}/edit', [AdminEmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [AdminEmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [AdminEmployeeController::class, 'destroy'])->name('employees.destroy');

    // Carousel CMS
    Route::get('/carousel', [AdminCarouselController::class, 'index'])->name('carousel.index');
    Route::post('/carousel', [AdminCarouselController::class, 'store'])->name('carousel.store');
    Route::post('/carousel/{carouselItem}/update', [AdminCarouselController::class, 'update'])->name('carousel.update');
    Route::delete('/carousel/{carouselItem}', [AdminCarouselController::class, 'destroy'])->name('carousel.destroy');

    // POS Kasir
    Route::get('/pos', [AdminPOSController::class, 'index'])->name('pos.index');
    Route::post('/pos/store', [AdminPOSController::class, 'store'])->name('pos.store');
    Route::get('/pos/receipt/{id}', [AdminPOSController::class, 'receipt'])->name('pos.receipt');

    // Chat Admin
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
});
