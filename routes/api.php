<?php

use Illuminate\Http\Request;
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

Route::get('base-info', [\App\Http\Controllers\Admin\BaseInfoController::class, 'storeEcp']);
Route::get('user-info', [\App\Http\Controllers\Admin\BaseInfoController::class, 'userInfo']);
Route::get('voice-info', [\App\Http\Controllers\Admin\BaseInfoController::class, 'voiceInfo']);
