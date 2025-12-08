<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\PurchaseRequestItemController;
use App\Http\Controllers\PurchaseApprovalController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DeliveryItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\AuthController;

// ---------------------------
// AUTH
// ---------------------------
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['web', 'auth.api.session']);

// ---------------------------
// GROUP API ADMIN (auth via session)
// ---------------------------
Route::prefix('admin')->middleware(['web'])->group(function () {
    // ---------------------------
    // USERS
    // , 'auth.api.session'
    // ---------------------------
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('/', 'index');          // Liste tous les users
        Route::get('/{id}', 'show');       // Détail d'un user
        Route::post('/create', 'store');         // Créer
        Route::put('/{id}', 'update');     // Modifier
        Route::delete('/{uuid}', 'destroy')->name('users.delete');
    });
    // ---------------------------
    // CENTERS
    // ---------------------------
    Route::prefix('centers')->controller(CenterController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
    // ---------------------------
    // SUPPLIERS
    // ---------------------------
    Route::prefix('suppliers')->controller(SupplierController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/store', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // ---------------------------
    // PRODUCTS
    // ---------------------------
    Route::prefix('products')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/store', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // ---------------------------
    // PURCHASE REQUESTS
    // ---------------------------
    Route::prefix('purchase-requests')->controller(PurchaseRequestController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::get('/approve/{uuid}/{status}', 'requestApproved');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // ---------------------------
    // PURCHASE REQUEST ITEMS
    // ---------------------------
    Route::prefix('purchase-request-items')->controller(PurchaseRequestItemController::class)->group(function () {
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // ---------------------------
    // PURCHASE APPROVALS
    // ---------------------------
    Route::prefix('purchase-approvals')->controller(PurchaseApprovalController::class)->group(function () {
        Route::post('/', 'store');   // Approuver ou rejeter
    });

    // ---------------------------
    // PURCHASE ORDERS
    // ---------------------------
    Route::prefix('purchase-orders')->controller(PurchaseOrderController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');     // Confirmer la commande
        Route::put('/{id}', 'update'); // Modifier si nécessaire
        Route::delete('/{id}', 'destroy');
    });

    // ---------------------------
    // DELIVERIES
    // ---------------------------
    Route::prefix('deliveries')->controller(DeliveryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::get('/order/confirm/{uuid}', 'deliveryOrderConfirm');
        Route::post('/', 'store');     // Enregistrer livraison
        Route::put('/{id}', 'update'); // Modifier
        Route::delete('/{id}', 'destroy');
    });

    // ---------------------------
    // DELIVERY ITEMS
    // ---------------------------
    Route::prefix('delivery-items')->controller(DeliveryItemController::class)->group(function () {
        Route::post('/', 'store');    // Ajouter produit reçu
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // ---------------------------
    // INVOICES
    // ---------------------------
    Route::prefix('invoices')->controller(InvoiceController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // ---------------------------
    // MONTHLY REPORTS
    // ---------------------------
    Route::prefix('monthly-reports')->controller(MonthlyReportController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
    });
});
