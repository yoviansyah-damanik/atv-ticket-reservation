<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\PackageController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\ReservationController;
use App\Http\Controllers\Backend\PaymentVendorController;

Route::middleware('auth', 'role:Administrator|Finance|Guide|Owner')
    ->as('dashboard.')
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])
            ->name('home');

        // UNIT CONTROLLER
        Route::get('/unit', [UnitController::class, 'index'])->name('unit');

        // PAYMENT VENDOR CONTROLLER
        Route::get('/payment_vendor', [PaymentVendorController::class, 'index'])->name('payment_vendor');

        // PACKAGE CONTROLLER
        Route::get('/package', [PackageController::class, 'index'])->name('package');

        // USER CONTROLLER
        Route::get('/user', [UserController::class, 'index'])->name('user');

        // RESERVATION CONTROLLER
        Route::controller(ReservationController::class)
            ->group(function () {
                Route::get('/reservation', 'index')->name('reservation');
                Route::as('reservation')
                    ->prefix('reservation')
                    ->group(function () {
                        Route::get('/create', 'create')
                            ->name('.create');
                        Route::post('/store', 'store')
                            ->name('.store');
                        Route::get('/edit/{id}', 'edit')
                            ->name('.edit');
                        Route::put('/update/{id}', 'update')
                            ->name('.update');
                    });
            });


        // PAYMENT CONTROLLER
        Route::controller(PaymentController::class)
            ->group(function () {
                Route::get('/payment', 'index')->name('payment');
                Route::as('payment')
                    ->prefix('payment')
                    ->group(function () {
                        Route::get('/create', 'create')
                            ->name('.create');
                        Route::post('/store', 'store')
                            ->name('.store');
                        Route::get('/edit/{id}', 'edit')
                            ->name('.edit');
                        Route::put('/update/{id}', 'update')
                            ->name('.update');
                    });
            });

        // PAYMENT CONTROLLER
        Route::controller(ReportController::class)
            ->group(function () {
                Route::as('report')
                    ->prefix('report')
                    ->group(function () {
                        Route::get('/unit', 'unit')
                            ->name('.unit');
                        Route::get('/reservation', 'reservation')
                            ->name('.reservation');
                        Route::get('/income', 'income')
                            ->name('.income');
                    });
            });
    });
