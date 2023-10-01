<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\ReservationController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/about', [AboutController::class, 'index'])
    ->name('about');

Route::middleware('auth', 'role:User')
    ->group(function () {
        // RESERVATION CONTROLLER
        Route::controller(ReservationController::class)
            ->as('reservation')
            ->group(function () {
                Route::get('/reservation', 'index');
                Route::post('/reservation', 'store')->name('.store');
            });

        // ACCOUNT CONTROLLER
        Route::controller(AccountController::class)
            ->group(function () {
                Route::get('/account', 'index')->name('account');
                Route::prefix('account')
                    ->as('account.')
                    ->group(function () {
                        Route::put('/account', 'update_account')->name('update');
                        Route::put('/password', 'update_password')->name('update.password');
                        Route::get('/history', 'history')->name('history');
                        Route::get('/history/{reservation:id}', 'show_history')->name('history.show');
                        Route::put('/history/{reservation:id}', 'update_payment')->name('history.show.payment');
                        Route::put('/history/{reservation:id}/cancel', 'cancel_reservation')->name('history.show.cancel');
                    });
            });
    });
