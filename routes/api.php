<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware('api')
    ->group(base_path('routes/api/v1/index.php'));
Route::prefix('v1/{profile_id}')
    ->name('api.v1.')
    ->middleware([
        'api',
        'auth:api',
        'profile.verified',
    ])
    ->group(base_path('routes/api/v1/profile.php'));
