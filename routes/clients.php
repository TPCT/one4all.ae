<?php

use App\Http\Controllers\Clients\CompaniesController;
use App\Http\Controllers\Clients\SiteController;
use App\Http\Controllers\Clients\ServicesController;
use App\Http\Middleware\StatusChecker;
use App\Http\Controllers\Clients\AuthController;


Route::middleware([
    StatusChecker::class,
])
->group(function(){
    Route::prefix('auth')->controller(AuthController::class)->group(function(){
        Route::any('login', 'login')->name('auth.login');
        Route::any('register', 'register')->name('auth.register');
    });
    Route::controller(SiteController::class)->group(function(){
       Route::get('/', 'index')->name('site.index');
       Route::get('/about-us', 'aboutUs')->name('site.about-us');
        Route::get('/newsletter/subscribe', 'newsletter')->name('newsletter.subscribe');
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
            Route::get('/{service}', 'show')->name('services.show');
        });
});
