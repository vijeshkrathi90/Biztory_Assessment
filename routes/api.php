<?php

use App\Http\Controllers\Api\V1\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Routes for SaleController
Route::group(['prefix' => 'v1/sales','as' => 'sales.', 'where' => ['id' => '[0-9]+'] ], function () {


    Route::get('/', [SaleController::class, 'index'])->name('index');
    Route::post('/', [SaleController::class, 'store'])->name('store');
    Route::get('/{id}', [SaleController::class, 'show'])->name('show');
    Route::put('/{id}', [SaleController::class, 'update'])->name('update');
    Route::delete('/{id}', [SaleController::class, 'destroy'])->name('destroy');

    Route::delete('/bulk-soft-delete', [SaleController::class, 'bulkSoftDelete'])->name('bulkSoftDelete');
    Route::delete('/force/{id}', [SaleController::class, 'forceDelete'])->name('forceDelete');
    Route::delete('/bulk-force-delete', [SaleController::class, 'bulkForceDelete'])->name('bulkForceDelete');
    Route::patch('/recover/{id}', [SaleController::class, 'recoverSoftDeleted'])->name('recoverSoftDeleted');
    Route::patch('/bulk-recover', [SaleController::class, 'bulkRecoverSoftDeleted'])->name('bulkRecoverSoftDeleted');
    Route::get('/soft-deleted', [SaleController::class, 'getSoftDeleted'])->name('getSoftDeleted');
    Route::get('/paginate', [SaleController::class, 'paginate'])->name('paginate');
    Route::get('/filter', [SaleController::class, 'filter'])->name('filter');
    Route::get('/total-sales', [SaleController::class, 'totalSales'])->name('totalSales');
});
