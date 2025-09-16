<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('pages.dashboard-general-dashboard');
// });
/**
 * Gunakan middleware untuk mendeteksi apakah user sudah login atau belum dengan cara auth/guest
 */
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/features/users', UserController::class);
    Route::resource('/features/products', ProductController::class);
    Route::resource('/features/categories', CategoryController::class);
    Route::resource('/features/sub-categories', SubCategoryController::class);
});
Route::get('/', function () {
    return view('pages.dashboard-general-dashboard');
})->middleware('auth');
