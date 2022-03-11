<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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

Route::post('login', [UserController::class,'login']);
Route::post('register', [UserController::class,'register']);

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('admin', [AdminController::class,'getAll']);
    Route::get('admin/{limit}/{offset}', [AdminController::class,'getAll']);
    Route::get('admin/{id}', [AdminController::class,'getById']);
    Route::post('admin/create', [AdminController::class,'insert']);
    Route::put('admin/{id}', [AdminController::class,'update']);
    Route::delete('admin/{id}', [AdminController::class,'delete']);
    
    Route::get('login/check', [LoginController::class,'loginCheck']);
    Route::post('logout', [LoginController::class,'logout']);   
});
