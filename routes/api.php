<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
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
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('login-by-user', [RegisterController::class, 'loginByUser']);

Route::middleware('auth:api')->group( function () {

Route::post('add-category', [CategoryController::class, 'addCategory']);
Route::post('image-upload', [CategoryController::class, 'imageUpload']);
    
});
