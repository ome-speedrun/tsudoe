<?php

use App\Http\Controllers\EventsResource;
use App\Http\Controllers\UsersResource;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users', UsersResource::class)->only(['show', 'store'])->parameter('users', 'id');
Route::resource('events', EventsResource::class)->only(['index', 'show', 'store'])->parameter('events', 'identifier');
