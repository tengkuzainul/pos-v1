<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Cashier\TransactionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false,
    'password.confirm' => false,
    'password.email' => false,
    'password.request' => false,
    'password.reset' => false,
    'password.update' => false,
]);

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['role:super-admin']);

Route::middleware(['auth', 'role:super-admin'])->group(function () {
    // route for RoleController
    Route::prefix('role')->group(function () {
        Route::get('/index', [RoleController::class, 'index'])->name('role.index');
        Route::get('/export/pdf', [RoleController::class, 'exportPdf'])->name('role.pdf');
        Route::get('/export/excel', [RoleController::class, 'exportExcel'])->name('role.excel');
        Route::get('/print', [RoleController::class, 'print'])->name('role.print');
        Route::get('/show/{name}', [RoleController::class, 'show'])->name('role.show');
        Route::delete('/delete/{uuid}', [RoleController::class, 'destroy'])->name('role.destroy');
    });

    // Route for PermissionController
    Route::prefix('permission')->group(function () {
        Route::get('/index', [PermissionController::class, 'index'])->name('permission.index');
        Route::get('/export/pdf', [PermissionController::class, 'exportPdf'])->name('permission.pdf');
        Route::get('/print', [PermissionController::class, 'print'])->name('permission.print');
        Route::get('/export/excel', [PermissionController::class, 'exportExcel'])->name('permission.excel');
        Route::delete('/delete/{uuid}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    });

    // Route for UserManagementController
    Route::prefix('user')->group(function () {
        Route::get('/index', [UserManagementController::class, 'index'])->name('user.index');
        Route::get('/show/{slug}', [UserManagementController::class, 'show'])->name('user.show');
        Route::post('/store', [UserManagementController::class, 'store'])->name('user.store');
        Route::delete('/delete/{id}', [UserManagementController::class, 'destroy'])->name('user.destroy');
        Route::put('/give-permission/{slug}', [UserManagementController::class, 'updatePermissions'])->name('user.permissions.update');
        Route::put('/update/{slug}', [UserManagementController::class, 'update'])->name('user.update');
        Route::put('/reset-password/{slug}', [UserManagementController::class, 'resetPassword'])->name('user.reset.password');
        Route::get('/export/excel', [UserManagementController::class, 'exportExcel'])->name('user.excel');
        Route::get('/print', [UserManagementController::class, 'print'])->name('user.print');
        Route::get('/export/pdf', [UserManagementController::class, 'exportPdf'])->name('user.pdf');
    });
});

Route::middleware(['auth', 'role:super-admin|admin'])->group(function () {
    // Route form CategoryController
    Route::prefix('category')->group(function () {
        Route::get('/index', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::put('/update/{uuid}', [CategoryController::class, 'update'])->name('category.update');
    });

    // Route for ProductController
    Route::prefix('product')->group(function () {
        Route::get('/index', [ProductController::class, 'index'])->name('product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::get('/edit/{uuid}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/create', [ProductController::class, 'store'])->name('product.store');
        Route::put('/update/{uuid}', [ProductController::class, 'update'])->name('product.update');
        Route::put('/update-thumbnail/{uuid}', [ProductController::class, 'updateThumbnail'])->name('product.update.image');
        Route::delete('/delete/{uuid}', [ProductController::class, 'destroy'])->name('product.destroy');

        // route Stock Informations
        Route::prefix('stock')->group(function () {
            Route::get('/index', [ProductController::class, 'stockData'])->name('product.stock');
        });
    });
});

Route::middleware(['auth', 'role:super-admin|kasir'])->group(function () {
    // Route for TransactionController
    Route::prefix('cashier')->group(function () {
        Route::get('/index', [TransactionController::class, 'index'])->name('transaction.index');
        Route::post('/add-to-cart', [TransactionController::class, 'addToCart'])->name('addToCart');
        Route::post('/remove-to-cart', [TransactionController::class, 'removeFromCart'])->name('removeFromCart');
    });
});
