<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\AccountController;
use App\Http\Controllers\Backend\PackageController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\ReservationController;
use App\Http\Controllers\Backend\PaymentVendorController;
use App\Http\Controllers\Backend\ScheduleController;

Route::middleware('auth', 'role:Administrator')
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
                Route::get('/reservation/{reservation:id}', 'show')->name('reservation.show');
                Route::put('/reservation/{reservation:id}/cancel', 'cancel')->name('reservation.cancel');
                Route::put('/reservation/{reservation:id}/confirmation', 'confirmation')->name('reservation.confirmation');
                Route::put('/reservation/{reservation:id}/confirm-payment', 'confirm_payment')->name('reservation.confirm-payment');
                Route::put('/reservation/{reservation:id}/set-unit', 'set_unit')->name('reservation.set-unit');
            });

        // ACCOUNT CONTROLLER
        Route::get('/account', [AccountController::class, 'index'])->name('account');

        // SCHEDULE
        Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');

        // REPORT CONTROLLER
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
