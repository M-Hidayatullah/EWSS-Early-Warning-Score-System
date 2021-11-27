<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\NewPasswordController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/diagnosa/histories/{id}/detail', [DiagnosaController::class, 'history'])->middleware('auth:api');
Route::get('/diagnosa/histories', [DiagnosaController::class, 'histories'])->middleware('auth:api');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');
Route::post('/diagnosa', [DiagnosaController::class, 'diagnosa'])->middleware('auth:api');
Route::get('/storage', [DiagnosaController::class, 'storage'])->middleware('auth:api');
Route::post('/forgot/password', [NewPasswordController::class, 'ForgotPassword']);

