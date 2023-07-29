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
Route::post('verified-otp', [RegisterController::class, 'verifiedOtp']);

Route::middleware('auth:api')->group( function () {
    
Route::post('loginout', [RegisterController::class, 'loginout']);
Route::post('user-list', [CategoryController::class, 'userList']);
Route::post('image-upload', [CategoryController::class, 'imageUpload']);  
 ///////////////// category ////////////////////////////////////
Route::post('category-list', [CategoryController::class, 'categoryList']);
Route::post('category-edit', [CategoryController::class, 'categoryEdit']);
Route::post('category-delete', [CategoryController::class, 'categoryDelete']);
///////////////////////Banner ///////////////////////////////
Route::post('banner-add', [CategoryController::class, 'bannerAdd']);
Route::post('banner-list', [CategoryController::class, 'bannerList']);
Route::post('banner-edit', [CategoryController::class, 'bannerEdit']);
Route::post('banner-delete', [CategoryController::class, 'bannerDelete']);


});
