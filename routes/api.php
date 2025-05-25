<?php

use App\Http\Controllers\Api\V1\BloodOxygenController;
use App\Http\Controllers\Api\V1\BloodPressureController;
use App\Http\Controllers\Api\V1\HeartRateController;
use App\Http\Controllers\Api\V1\HydrationReminderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BloodSugarController;

Route::prefix('v1')
    ->middleware('api')
    ->group(base_path('routes/api/v1/index.php'));


Route::group([
    'prefix'     => 'v1/{profile_id}',
    'middleware' => [
        'api',
        'auth:api',
        'profile.verified'
    ]
], function () {
    // Heart Rate Routes
    Route::apiResource('heart-rates', HeartRateController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'heart-rates', 'controller' => HeartRateController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('blood-pressures', BloodPressureController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'blood-pressures', 'controller' => BloodPressureController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('blood-oxygens', BloodOxygenController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'blood-oxygens', 'controller' => BloodOxygenController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('hydration-reminders', HydrationReminderController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'hydration-reminders', 'controller' => HydrationReminderController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });

        // Blood Sugar Routes
    Route::apiResource('blood-sugars', BloodSugarController::class)->only(['index', 'store', 'destroy']);
    Route::group(['prefix' => 'blood-sugars'], function () {
        Route::get('units', [BloodSugarController::class, 'units']);
        Route::get('sugar-schedules', [BloodSugarController::class, 'sugarSchedules']);
        Route::post('range-guideline', [BloodSugarController::class, 'rangeGuideline']);
        Route::get('statistics', [BloodSugarController::class, 'getStatistics']);
        Route::post('bulk-export', [BloodSugarController::class, 'exportToCsv']);
        Route::post('statistics', [BloodSugarController::class, 'statistics']);
    });
});

