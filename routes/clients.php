<?php

use App\Http\Controllers\Clients\HomeController;
use App\Http\Middleware\StatusChecker;
Route::middleware([
    StatusChecker::class,
])
->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
