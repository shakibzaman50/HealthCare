<?php

use App\Http\Controllers\Api\V1\HabitTaskController;
use App\Http\Controllers\Api\V1\WaterIntakeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BloodOxygenController;
use App\Http\Controllers\Api\V1\BloodPressureController;
use App\Http\Controllers\Api\V1\HeartRateController;
use App\Http\Controllers\Api\V1\HydrationReminderController;
use App\Http\Controllers\Api\V1\ProfileAssesmentController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\ReminderNotificationController;

Route::group([], function () {
    // Profile Assesment Routes
    Route::get('profile', [ProfileController::class, 'show'])->name('user.get.profile');
    Route::post('profile-update', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('user.profile.delete');
    Route::post('profile-assessment', [ProfileAssesmentController::class, 'store'])
        ->name('profile-assessment.store');
    Route::get('profile-assessment', [ProfileAssesmentController::class, 'show'])
        ->name('profile-assessment.show');

    // Notification Routes
    Route::get('notifications', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('notifications', [NotificationController::class, 'update'])->name('notifications.update');

    // Reminder Notification Routes
    Route::get('reminder-notifications', [ReminderNotificationController::class, 'show'])->name('reminder-notifications.show');
    Route::post('reminder-notifications', [ReminderNotificationController::class, 'update'])->name('reminder-notifications.update');

    // Heart Rate Routes
    Route::apiResource('heart-rates', HeartRateController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'heart-rates', 'controller' => HeartRateController::class], function () {
        Route::get('latest-record', 'latestRecord');
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });

    // Blood Pressure Routes
    Route::apiResource('blood-pressures', BloodPressureController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'blood-pressures', 'controller' => BloodPressureController::class], function () {
        Route::get('latest-record', 'latestRecord');
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });

    // Blood Oxygen Routes
    Route::apiResource('blood-oxygens', BloodOxygenController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'blood-oxygens', 'controller' => BloodOxygenController::class], function () {
        Route::get('latest-record', 'latestRecord');
        Route::get('last-week-average', 'lastWeekAverage');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });

    // Water Intake Routes
    Route::apiResource('water-intakes', WaterIntakeController::class)->only(['index','store', 'destroy']);
    Route::group(['prefix' => 'water-intakes', 'controller' => WaterIntakeController::class], function () {
        Route::get('latest-record', 'latestRecord');
        Route::post('chart-data', 'chartData');
        Route::post('filter', 'filter');
        Route::post('export', 'export');
    });

    // Hydration Reminder Routes
    Route::apiResource('hydration-reminders', HydrationReminderController::class)->only(['index','store', 'destroy']);

    // Habit Reminder Routes
    Route::apiResource('habit-tasks', HabitTaskController::class)->only(['store','show','update','destroy']);
    Route::group(['prefix' => 'habit-tasks', 'controller' => HabitTaskController::class], function () {
        Route::post('history', 'habitHistory');
    });
    Route::get('habit-list/{id?}', [HabitTaskController::class, 'habitList']);
});