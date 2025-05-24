<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BloodOxygenController;
use App\Http\Controllers\Api\V1\BloodPressureController;
use App\Http\Controllers\Api\V1\HeartRateController;
use App\Http\Controllers\Api\V1\HydrationReminderController;
use App\Http\Controllers\Api\V1\ProfileAssesmentController;

Route::group([], function () {
    // Profile Assesment Routes
    Route::resources([
        'profile-assessment' => ProfileAssesmentController::class
    ]);
    // Heart Rate Routes
    Route::apiResource('heart-rates', HeartRateController::class)->only(['index', 'store', 'destroy']);
    Route::group(['prefix' => 'heart-rates', 'controller' => HeartRateController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('blood-pressures', BloodPressureController::class)->only(['index', 'store', 'destroy']);
    Route::group(['prefix' => 'blood-pressures', 'controller' => BloodPressureController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('blood-oxygens', BloodOxygenController::class)->only(['index', 'store', 'destroy']);
    Route::group(['prefix' => 'blood-oxygens', 'controller' => BloodOxygenController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Heart Rate Routes
    Route::apiResource('hydration-reminders', HydrationReminderController::class)->only(['index', 'store', 'destroy']);
    Route::group(['prefix' => 'hydration-reminders', 'controller' => HydrationReminderController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
});
