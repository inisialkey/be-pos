<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubCategoryController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// TODO : Fix Agar saat token expired, message yang dikembalikan adalah unathenticated bukan login
Route::group([
    'middleware' => ['auth:sanctum', 'admin'],
    'as' => 'api.',
    'prefix' => 'admin'
], function () {
    Route::get('/user', [AuthController::class, 'fetch']);
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/sub-categories', SubCategoryController::class);
});

// Setiap Penggunaan api yang memakai token diaruskan melewati middleware sanctum jika tidak data kembaliannya null
Route::group([
    'middleware' => ['auth:sanctum'],
    'as' => 'api.',
    'prefix' => 'v1'
], function () {
    Route::get('/user', [AuthController::class, 'fetch']);
    Route::get('/categories', CategoryController::class, 'fetch');
    Route::get('/products', ProductController::class, 'fetch');
    Route::get('/sub-categories', SubCategoryController::class, 'fetch');
    Route::apiResource('/orders', OrderController::class);
});
