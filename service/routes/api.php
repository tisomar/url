<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UrlController;

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




//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/user-profile', [AuthController::class, 'userProfile'])->name('user-profile');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'url'

], function ($router) {
    Route::post('/create', [UrlController::class,'create'])->name('create');
    Route::get('/list', [UrlController::class,'list'])->name('list');
    Route::post('/update', [UrlController::class,'update'])->name('update');
    Route::post('/show', [UrlController::class,'show'])->name('show');
});




