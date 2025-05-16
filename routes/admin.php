<?php

use App\Http\Controllers\Admin\Config\FeelingListController;
use App\Http\Controllers\Admin\Config\HeightUnitController;
use App\Http\Controllers\Admin\Config\MedicineTypeController;
use App\Http\Controllers\Admin\Config\MedicineUnitController;
use App\Http\Controllers\Admin\Config\SugarScheduleController;
use App\Http\Controllers\Admin\Config\SugarUnitController;
use App\Http\Controllers\Admin\Config\WaterUnitController;
use App\Http\Controllers\Admin\Config\WeightUnitController;
use Illuminate\Support\Facades\Route;

// All Admin Config Routes

Route::resource('sugar-units', SugarUnitController::class);
Route::resource('water-units', WaterUnitController::class);
Route::resource('weight-units', WeightUnitController::class);
Route::resource('feeling-lists', FeelingListController::class);
Route::resource('height-units', HeightUnitController::class);
Route::resource('medicine-units', MedicineUnitController::class);
Route::resource('medicine-types', MedicineTypeController::class);
Route::resource('sugar-schedules', SugarScheduleController::class);