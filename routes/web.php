<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::prefix('/urls')->group(function () {
    Route::get('/', [UrlController::class, 'create'])
        ->name('url.create');

    Route::post('/shorten', [UrlController::class, 'store'])
        ->name('url.store')
        ->middleware(sprintf(
            'throttle:%s,1',
            config('services.app.rate_limit_per_min')
        ));

    Route::get('/admin', [UrlController::class, 'index'])
        ->name('url.admin');

    Route::get('/{shortCode}', [UrlController::class, 'show'])
        ->name('url.show');
});

Route::get('/{shortCode}', [UrlController::class, 'redirect'])
    ->name('url.redirect');

require __DIR__.'/auth.php';
