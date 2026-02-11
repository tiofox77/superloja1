<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\SystemUpdateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Protected API routes (require api_token + rate limit: 30 req/min)
Route::middleware([\App\Http\Middleware\ApiTokenMiddleware::class, 'throttle:30,1'])->prefix('v1')->group(function () {

    // Products CRUD
    Route::apiResource('products', ProductController::class);

    // Categories CRUD (root only)
    Route::apiResource('categories', CategoryController::class);

    // Subcategories CRUD (categories with parent_id)
    Route::apiResource('subcategories', SubcategoryController::class);

    // Brands CRUD
    Route::apiResource('brands', BrandController::class);

    // POS
    Route::prefix('pos')->group(function () {
        Route::get('products', [PosController::class, 'products']);
        Route::get('products/barcode/{barcode}', [PosController::class, 'productByBarcode']);
        Route::get('categories', [PosController::class, 'categories']);
        Route::post('sale', [PosController::class, 'sale']);
        Route::get('sales', [PosController::class, 'sales']);
        Route::get('sales/{id}', [PosController::class, 'saleShow']);
    });
});

// System Update Routes (use own X-Update-Token authentication)
Route::prefix('v1/system')->group(function () {
    // Status do sistema (público)
    Route::get('status', [SystemUpdateController::class, 'status']);

    // Updates (requerem X-Update-Token)
    Route::prefix('updates')->group(function () {
        Route::get('check', [SystemUpdateController::class, 'checkUpdates']);
        Route::post('upload', [SystemUpdateController::class, 'uploadUpdate']);
    });

    // Ficheiros
    Route::post('files/upload', [SystemUpdateController::class, 'uploadFile']);

    // Comandos
    Route::post('commands/run', [SystemUpdateController::class, 'runCommand']);

    // Backup
    Route::prefix('backup')->group(function () {
        Route::get('list', [SystemUpdateController::class, 'listBackups']);
        Route::post('create', [SystemUpdateController::class, 'createBackup']);
        Route::post('restore', [SystemUpdateController::class, 'restoreBackup']);
    });

    // Otimização
    Route::post('optimize', [SystemUpdateController::class, 'optimize']);
});
