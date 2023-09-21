<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('guest')
    ->group(function () {
        Route::controller(AuthController::class)
            ->group(function () {
                // AUTHENTICATION
                Route::get('/login', 'login')->name('login');
                Route::post('/login', 'do_login')->name('login.do');

                // REGISTER
                Route::get('/register', 'register')->name('register');
                Route::post('/register', 'do_register')->name('register.do');
            });
    });

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
