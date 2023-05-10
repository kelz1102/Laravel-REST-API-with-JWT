<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');

        // Auth
    Route::middleware('auth:api')->group(function(){
        Route::put('dark/{id}', 'darkMode');
        Route::post('logout', 'logout');
        Route::get('user', 'user');

        
        // Chats
        Route::controller(ChatController::class)->group(function () {
            Route::get('users/search', 'search');
            Route::get('chat/{id}', 'index');
            Route::post('chat', 'store');
            Route::get('chats', 'hasChats');
            Route::delete('chat/{id}', 'destroy');
        });

            // Messages
        Route::controller(MessageController::class)->group(function () {    
            Route::get('messages/{id}', 'index');
            Route::post('message/{id}', 'store');
            Route::delete('delete/{id}', 'destroy');
        });
       
    });
});