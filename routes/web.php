<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


Route::middleware(['role:user'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logoutUser');
    Route::get('/user-call/{id}/{voice_id}', [App\Http\Controllers\HomeController::class, 'callUser'])->name('callUser');
    Route::post('/update-status', [App\Http\Controllers\HomeController::class, 'updateStatus'])->name('updateStatus');
    //snip
    Route::resource('snip_by_user',\App\Http\Controllers\SnipController::class);
    //voice
    Route::resource('voice_by_user',\App\Http\Controllers\VoiceRecordController::class);
    //trunk
    Route::resource('trunk_by_user',\App\Http\Controllers\TrunkController::class);

});

Route::middleware(['role:admin'])->prefix('admin_panel')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index']); // /admin
    Route::get('/admin_panel', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('homeAdmin'); // /admin
    Route::get('/logout-user', [App\Http\Controllers\Admin\HomeController::class, 'logout'])->name('logout'); // /admin
    Route::get('/admin-call/{id}', [\App\Http\Controllers\Admin\BaseInfoController::class, 'callUserAdmin'])->name('callUserAdmin');
    Route::get('/base-list', [\App\Http\Controllers\Admin\BaseInfoController::class, 'getBaseList'])->name('baseList');
    Route::post('/base-set-user', [\App\Http\Controllers\Admin\BaseInfoController::class, 'setUserBaseInfo'])->name('baseSetUser');

    Route::resource('users',\App\Http\Controllers\Admin\UserController::class);
    Route::resource('base_info',\App\Http\Controllers\Admin\BaseInfoController::class);
    Route::resource('status',\App\Http\Controllers\Admin\StatusController::class);
    //snip
    Route::resource('snip_by_admin',\App\Http\Controllers\Admin\SnipAdminController::class);
    //voice
    Route::resource('voice_by_admin',\App\Http\Controllers\Admin\VoiceAdminController::class);
    //Subscription
    Route::resource('subscriptions_user',\App\Http\Controllers\Admin\SubscriptionUserController::class);
    Route::get('/subscription-all-user', [\App\Http\Controllers\Admin\SubscriptionUserController::class, 'getSubscriptionsUsers'])->name('subscriptionAllUsers');
    Route::get('/edit-subscription-user/{id}', [\App\Http\Controllers\Admin\SubscriptionUserController::class, 'editSubscriptionsUsers'])->name('editSubscriptionUser');
    Route::put('/update-subscription-user/{id}', [\App\Http\Controllers\Admin\SubscriptionUserController::class, 'updateSubscriptionsUsers'])->name('updateSubscriptionUser');
    //trunk
    Route::resource('trunk_by_admin',\App\Http\Controllers\Admin\AdminTrunkController::class);

});
