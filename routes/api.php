<?php


use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->middleware('api')
    ->group(base_path('routes/api/v1/index.php'));
Route::prefix('v1/{profile_id}')
    ->middleware([
        'api',
        'auth:api',
        'profile.verified',
    ])
    ->group(base_path('routes/api/v1/profile.php'));
