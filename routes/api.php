<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\emailVerifController;
use App\Http\Controllers\UserController;

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

Route::post('/register', [RegisController::class, 'register']);
Route::post('/login', [loginController::class, 'login'])->name('login');

Route::get('email/verify/{id}', [emailVerifController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [emailVerifController::class, 'resend'])->name('verification.resend');

Route::group(['middleware' => ['auth:sanctum']], function () {

    //show semua data
    Route::get('/profile', [UserController::class, 'showProfile']);
    //show data by id
    Route::get('/profile/{id}', [UserController::class, 'show']);
    //update data
    Route::put('/profile', [UserController::class, 'updateProfile']);

    //logout
    Route::get('/logout', [loginController::class, 'logout']);
});