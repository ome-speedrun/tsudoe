<?php

use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\DiscordAuthController;
use App\Http\Controllers\Admin\TokenController;
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

Route::middleware(['auth'])->group(function () {

    Route::get('/applications', [ApplicationController::class, 'index'])->name('.applications');
    Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('.applications.show');
    Route::name('.applications')->prefix('/applications/{applicationId}')->group(function () {
        Route::name('.tokens')->group(function () {
            Route::post('/tokens/revoke', [TokenController::class, 'revoke'])->name('.revoke');
            Route::get('/tokens/generate', [TokenController::class, 'viewGenerate'])->name('.generate');
            Route::post('/tokens/generate', [TokenController::class, 'generate'])->name('.generate');
        });
    });

    Route::get('/logout', [DiscordAuthController::class, 'logout'])->name('.logout');


});


Route::view('/login', 'login')->name('.login');
Route::get('/login/discord', [DiscordAuthController::class, 'login'])->name('.login.discord');
Route::get('/callback/discord', [DiscordAuthController::class, 'callback'])->name('.callback.discord');
