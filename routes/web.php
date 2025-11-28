<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\PurchaseOrderController;
use Inertia\Inertia;

// Route::middleware(['auth'])->group(function () {
// // DASHBOARD
Route::middleware('guest')->prefix('auth')->group(function () {
    Route::get('/login', fn() => Inertia::render('views/LoginEmail'))->name('login');
    Route::get('/otp', fn() => Inertia::render('views/OtpVerify'))->name('otp');
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
});

// Routes protégées (utilisateur connecté)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ROUTES POUR LiaisonOfficer UNIQUEMENT (PAS de dashboard)
    Route::middleware('role:LiaisonOfficer,Requester,BudgetOfficer,Vendor,Finance')->group(function () {
        // PURCHASE ORDERS
        Route::controller(PurchaseOrderController::class)
            ->prefix('purchase-orders')
            ->group(function () {
                Route::get('/', 'index')->name('purchase-orders.index');
                Route::get('/delivery/{uuid}', 'orderDelivery')->name('purchase-orders.delivery');
                Route::get('/{uuid}', 'getOrder')->name('purchase-orders.detail');
                // Route::get('/approve/{uuid}', 'confirmFromMail')->name('orders.approve');
                // Route::get('/reject/{uuid}', 'rejectFromMail')->name('orders.reject');
            });
        // DELIVERIES
        Route::controller(DeliveryController::class)->prefix('deliveries')->group(function () {
            Route::get('/order/{uuid}', 'deliveryOrder')->name('admin.deliveries.index');
        });
    });

    // ROUTES ADMIN (avec dashboard)
    // ROUTES POUR TOUS LES AUTRES RÔLES (Requester, BudgetOfficer, Vendor, Finance)
    Route::middleware('role:Requester,BudgetOfficer,Vendor,Finance')->group(function () {

        // Dashboard
        Route::get('/', [PurchaseRequestController::class, 'index'])->name('dashboard');

        // USERS
        Route::controller(UserController::class)->prefix('users')->group(function () {
            Route::get('/', 'index')->name('admin.users.index');
            Route::get('/{id}', 'show')->name('admin.users.show');
        });

        // CENTERS
        Route::controller(CenterController::class)->prefix('centers')->group(function () {
            Route::get('/', 'index')->name('admin.centers.index');
            Route::get('/{id}', 'show')->name('admin.centers.show');
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
            // Route::get('/approve/{uuid}', 'approveFromMail')->name('purchase-request.approve');
            // Route::get('/reject/{uuid}', 'rejectFromMail')->name('purchase-request.reject');
            Route::get('/{uuid}', 'show')->name('admin.requests.show');
        });



        // MONTHLY REPORTS
        Route::controller(MonthlyReportController::class)->prefix('reports')->group(function () {
            Route::get('/', 'index')->name('admin.reports.index');
        });
    });


    // PURCHASE REQUESTS
    Route::controller(PurchaseRequestController::class)->prefix('requests')->group(function () {
        Route::get('/approve/{uuid}', 'approveFromMail')->name('purchase-request.approve');
        Route::get('/reject/{uuid}', 'rejectFromMail')->name('purchase-request.reject');
    });

    Route::controller(PurchaseOrderController::class)
        ->prefix('purchase-orders')
        ->group(function () {
            Route::get('/approve/{uuid}', 'confirmFromMail')->name('orders.approve');
            Route::get('/reject/{uuid}', 'rejectFromMail')->name('orders.reject');
        });
});
