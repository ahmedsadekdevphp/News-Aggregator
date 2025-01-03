<?php

use App\Http\Controllers\Api\User\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Api\User\RegisterController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\UserPreferenceController;
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


Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:10,1');
Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:10,1');

Route::middleware('auth:api')->group(function () {
    Route::get('/search/lookups', [NewsController::class, 'searchFormData']);
    Route::get('/search', [NewsController::class, 'search']);
    Route::get('/news/feed', [NewsController::class, 'newsFeed']);

    Route::get('/preferences/lookups', [UserPreferenceController::class, 'getPreferencesLookups']);
    Route::get('/user/preferences', [UserPreferenceController::class, 'showPreferences']);
    Route::post('/user/preferences', [UserPreferenceController::class, 'savePreferences']);


    Route::post('/logout', [AuthController::class, 'logout']);
});
