<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\ObjectTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HouseImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ВСИЧКИ логнати потребители могат ДА ГЛЕДАТ (READ-ONLY)
Route::middleware(['auth'])->group(function () {
    // Виж къщи (само списък)
    Route::get('admin/houses', [HouseController::class, 'index'])->name('admin.houses.index');
    
    // Виж населени места (само списък)
    Route::get('admin/settlements', [SettlementController::class, 'index'])->name('admin.settlements.index');
    
    // Виж типове обекти (само списък)
    Route::get('admin/object-types', [ObjectTypeController::class, 'index'])->name('admin.object-types.index');
});

// САМО администратори могат да ДОБАВЯТ, РЕДАКТИРАТ, ИЗТРИВАТ
Route::middleware(['auth', 'admin'])->group(function () {
    // Потребители (само админи)
    Route::resource('admin/users', UserController::class)->names('admin.users');
    
    // Къщи - CREATE, EDIT, DELETE
    Route::get('admin/houses/create', [HouseController::class, 'create'])->name('admin.houses.create');
    Route::post('admin/houses', [HouseController::class, 'store'])->name('admin.houses.store');
    Route::get('admin/houses/{house}/edit', [HouseController::class, 'edit'])->name('admin.houses.edit');
    Route::patch('admin/houses/{house}', [HouseController::class, 'update'])->name('admin.houses.update');
    Route::delete('admin/houses/{house}', [HouseController::class, 'destroy'])->name('admin.houses.destroy');
    
    // Населени места - CREATE, EDIT, DELETE
    Route::get('admin/settlements/create', [SettlementController::class, 'create'])->name('admin.settlements.create');
    Route::post('admin/settlements', [SettlementController::class, 'store'])->name('admin.settlements.store');
    Route::get('admin/settlements/{settlement}/edit', [SettlementController::class, 'edit'])->name('admin.settlements.edit');
    Route::patch('admin/settlements/{settlement}', [SettlementController::class, 'update'])->name('admin.settlements.update');
    Route::delete('admin/settlements/{settlement}', [SettlementController::class, 'destroy'])->name('admin.settlements.destroy');
    
    // Типове обекти - CREATE, EDIT, DELETE
    Route::get('admin/object-types/create', [ObjectTypeController::class, 'create'])->name('admin.object-types.create');
    Route::post('admin/object-types', [ObjectTypeController::class, 'store'])->name('admin.object-types.store');
    Route::get('admin/object-types/{object_type}/edit', [ObjectTypeController::class, 'edit'])->name('admin.object-types.edit');
    Route::patch('admin/object-types/{object_type}', [ObjectTypeController::class, 'update'])->name('admin.object-types.update');
    Route::delete('admin/object-types/{object_type}', [ObjectTypeController::class, 'destroy'])->name('admin.object-types.destroy');
    
    // Изтриване на снимки
    Route::delete('admin/house-images/{houseImage}', [HouseImageController::class, 'destroy'])
        ->name('admin.house-images.destroy');
});

require __DIR__.'/auth.php';