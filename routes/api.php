<?php

use App\Http\Controllers\Admin\Api\ConcertController;
use App\Http\Controllers\Api\Admin\ConcertController as AdminConcertController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\BookConcertController;
use App\Http\Controllers\Api\User\ConcertController as UserConcertController;
use App\Http\Controllers\Api\User\MyOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('admin')->group(function () {
        Route::resource('konser', AdminConcertController::class);
        Route::resource('transaksi', TransactionController::class);
    });

    Route::get('orderan-saya', [MyOrderController::class, 'index']);
    Route::post('order-tiket/{concert:slug}', [BookConcertController::class, 'store']);
    Route::post('pembayaran', [MyOrderController::class, 'processPaymentTicket']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/konser', [UserConcertController::class, 'index']);
Route::get('/konser/{concert:slug}', [UserConcertController::class, 'show']);
