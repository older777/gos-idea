<?php

use Illuminate\Support\Facades\Route;
use Older777\GosIdea\Controllers\BookingController;

Route::middleware(['throttle:huntingCore', 'api'])->prefix('api')->group(function () {
    Route::get('/guides', [BookingController::class, 'guides'])->name('guides');
    Route::post('/bookings', [BookingController::class, 'bookings'])->name('bookings');
});
