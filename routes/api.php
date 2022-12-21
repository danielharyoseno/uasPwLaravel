<?php

use App\Http\Controllers\emailVerifController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\RegisController;
use App\Http\Controllers\UserController;
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
Route::get('organizer', 'Api\OrganizerController@index');
Route::get('organizer/{id}', 'Api\OrganizerController@show');
Route::post('organizer', 'Api\OrganizerController@store');
Route::put('organizer/{id}', 'Api\OrganizerController@update');
Route::delete('organizer/{id}', 'Api\OrganizerController@destroy');

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

    //Organizer
    Route::get('organizer', [OrganizerController::class, 'index']);
    Route::get('organizer/{id}', [OrganizerController::class, 'show']);
    Route::post('organizer', [OrganizerController::class, 'store']);
    Route::put('organizer/{id}', [OrganizerController::class, 'update']);
    Route::delete('organizer/{id}', [OrganizerController::class, 'destroy']);

    //Event
    Route::get('event', [EventController::class, 'index']);
    Route::get('event/{id}', [EventController::class, 'show']);
    Route::post('event', [EventController::class, 'store']);
    Route::put('event/{id}', [EventController::class, 'update']);
    Route::delete('event/{id}', [EventController::class, 'destroy']);
});