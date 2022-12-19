<?php

use App\Http\Controllers\emailVerifController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\RegisController;
use App\Http\Controllers\UserController;
use App\Models\Organizer;
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

Route::post('/register', [RegisController::class, 'register']);
Route::post('/login', [loginController::class, 'login'])->name('login');

Route::get('email/verify/{id}', [emailVerifController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [emailVerifController::class, 'resend'])->name('verification.resend');

//Organizer
Route::get('organizer', [OrganizerController::class, 'index']);
Route::get('organizer/{id}', [OrganizerController::class, 'show']);
Route::post('organizer', [OrganizerController::class, 'store']);
Route::put('organizer/{id}', [OrganizerController::class, 'update']);
Route::delete('organizer/{id}', [OrganizerController::class, 'delete']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //show semua data
    Route::get('/profile', [UserController::class, 'showProfile']);
    //show data by id
    Route::get('/profile/{id}', [UserController::class, 'show']);
    //update data
    Route::put('/profile', [UserController::class, 'updateProfile']);

    //logout
    Route::get('/logout', [loginController::class, 'logout']);

    //pengumuman
    Route::get('announcement', 'Api\AnnouncementController@index');
    Route::get('announcement/{id}', 'Api\AnnouncementController@show');
    Route::post('announcement', 'Api\AnnouncementController@store');
    Route::put('announcement/{id}', 'Api\AnnouncementController@update');
    Route::delete('announcement/{id}', 'Api\AnnouncementController@destroy');

});