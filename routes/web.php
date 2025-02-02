<?php

use App\Http\Controllers\Clients\CompaniesController;
use App\Http\Controllers\Clients\IndicatorController;
use App\Http\Controllers\Clients\PaymentController;
use App\Http\Controllers\Clients\SiteController;
use App\Http\Controllers\Clients\ServicesController;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\StatusChecker;
use App\Http\Controllers\Clients\AuthController;

Route::get('/minify/{any}', [\App\Http\Controllers\MinifyController::class, 'minify'])->name('minify');

Route::prefix('/{locale?}/')
    ->where(['locale' => implode('|', array_keys(config('app.locales')))])
    ->middleware(StatusChecker::class)
    ->group(function(){
        Route::prefix('auth')->controller(AuthController::class)->group(function(){
            Route::any('login', 'login')->name('auth.login');
            Route::any('register', 'register')->name('auth.register');
            Route::any('reset-password', 'forgotPassword')->name('auth.reset-password');

            Route::middleware('auth:clients')->group(function(){
                Route::any('profile', 'profile')->name('profile.edit');
                Route::post('logout', 'logout')->name('auth.logout');
            });
        });

        Route::controller(SiteController::class)->group(function(){
            Route::get('/', 'index')->name('site.index');
            Route::get('/about-us', 'aboutUs')->name('site.about-us');
            Route::get('/newsletter/subscribe', 'newsletter')->name('newsletter.subscribe');
            Route::get('/mode/{mode}', 'mode')->name('site.mode');
        });

        Route::get('/', [SiteController::class, 'index'])->name('site.index');

        Route::prefix('trading-companies')
            ->controller(CompaniesController::class)
            ->group(function(){
                Route::get('/', 'index')->name('companies.index');
            });

        Route::prefix('services')
            ->controller(ServicesController::class)
            ->group(function(){
                Route::get('/cashback', 'cashback')->name('services.cashback');
                Route::any('/{service}', 'show')->name('services.show');
            });

        Route::prefix('indicator')
            ->controller(IndicatorController::class)
            ->group(function(){
                Route::get('/', 'index')->name('indicator.index');
            });

        Route::prefix('payment')
            ->controller(PaymentController::class)
            ->group(function(){
                Route::get('/{type}/{model}/process', 'process_transaction')->name('payment.process');
                Route::get('/{type}/{model}/success', 'success_transaction')->name('payment.success');
                Route::get('/{type}/{model}/failed', 'failed_transaction')->name('payment.failed');
            });
    });
