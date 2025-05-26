<?php

use App\Http\Controllers\Api\V1\BloodOxygenController;
use App\Http\Controllers\Api\V1\BloodPressureController;
use App\Http\Controllers\Api\V1\HabitTaskController;
use App\Http\Controllers\Api\V1\HeartRateController;
use App\Http\Controllers\Api\V1\HydrationReminderController;
use Illuminate\Support\Facades\Route;

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
    // Blood Pressure Routes
    Route::apiResource('blood-pressures', BloodPressureController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'blood-pressures', 'controller' => BloodPressureController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Blood Oxygen Routes
    Route::apiResource('blood-oxygens', BloodOxygenController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'blood-oxygens', 'controller' => BloodOxygenController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Hydration Reminder Routes
    Route::apiResource('hydration-reminders', HydrationReminderController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'hydration-reminders', 'controller' => HydrationReminderController::class], function () {
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });
    // Habit Reminder Routes
    Route::apiResource('habit-tasks', HabitTaskController::class)->only(['index','store', 'destroy']);
//    Route::group(['prefix' => 'habit-lists', 'controller' => HabitTaskController::class], function () {
//        Route::get('last-week-average', 'lastWeekAverage');
//    });
    Route::get('habit-list/{id?}', [HabitTaskController::class, 'habitList']);

});

