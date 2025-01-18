<?php

use App\Http\Controllers\Clients\CompaniesController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\ServicesController;
use App\Http\Middleware\StatusChecker;
Route::middleware([
    StatusChecker::class,
])
->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::prefix('trading-companies')
        ->controller(CompaniesController::class)
        ->group(function(){
            Route::get('/', 'index')->name('companies.index');
    });

    Route::prefix('services')
        ->controller(ServicesController::class)
        ->group(function(){
            Route::get('/{service}', 'show')->name('services.show');
        });
});
