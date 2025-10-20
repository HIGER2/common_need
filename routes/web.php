<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\PurchaseOrderController;

// Route::middleware(['auth'])->group(function () {
// // DASHBOARD
Route::get('/', [UserController::class, 'index'])->name('dashboard');


Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::get('/', 'index')->name('admin.users.index');
    Route::get('/{id}', 'show')->name('admin.users.show');
});

// CENTERS
Route::controller(CenterController::class)->prefix('centers')->group(function () {
    Route::get('/', 'index')->name('admin.centers.index');
    Route::get('/{id}', 'show')->name('admin.centers.show');
});

// orders
Route::controller(PurchaseOrderController::class)->prefix('purchase-orders')->group(function () {
    Route::get('/', 'index')->name('admin.suppliers.index');
    Route::get('/{id}', 'show')->name('admin.suppliers.show');
});



// SUPPLIERS
Route::controller(SupplierController::class)->prefix('suppliers')->group(function () {
    Route::get('/', 'index')->name('admin.suppliers.index');
    Route::get('/{id}', 'show')->name('admin.suppliers.show');
});

// PRODUCTS
Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/', 'index')->name('admin.products.index');
    Route::get('/{id}', 'show')->name('admin.products.show');
});

// PURCHASE REQUESTS
Route::controller(PurchaseRequestController::class)->prefix('requests')->group(function () {
    Route::get('/', 'index')->name('admin.requests.index');
    Route::get('/{id}', 'show')->name('admin.requests.show');
});

// DELIVERIES
Route::controller(DeliveryController::class)->prefix('deliveries')->group(function () {
    Route::get('/', 'index')->name('admin.deliveries.index');
    Route::get('/{id}', 'show')->name('admin.deliveries.show');
});

// MONTHLY REPORTS
Route::controller(MonthlyReportController::class)->prefix('reports')->group(function () {
    Route::get('/', 'index')->name('admin.reports.index');
});
// });
