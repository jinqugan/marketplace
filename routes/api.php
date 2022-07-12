<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Stock\GameController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => ['guest', 'auth.source'],
], function () {
    Route::prefix('auth')->namespace('Auth')->group(function () {
        Route::post('/register', [RegisterController::class, 'store']);
    });
});

Route::group([
    'middleware' => [],
], function () {
    Route::prefix('stock')->namespace('Stock')->group(function () {
        Route::get('/', [GameController::class, 'index']);
        Route::post('/', [GameController::class, 'store']);
        Route::post('/purchase', [GameController::class, 'purchase']);
        Route::post('/payment', [GameController::class, 'payment']);
        Route::get('/payment_method', [GameController::class, 'paymentMethod']);
    });
});
