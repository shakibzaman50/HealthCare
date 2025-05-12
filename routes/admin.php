<?php

use App\Http\Controllers\Backend\BloodPressureUnitController;
use App\Http\Controllers\Backend\FeelingListController;
use App\Http\Controllers\Backend\HeartRateUnitController;
use App\Http\Controllers\Backend\HeightUnitController;
use App\Http\Controllers\Backend\MedicineUnitController;
use App\Http\Controllers\Backend\SugarUnitController;
use App\Http\Controllers\Backend\WaterUnitController;
use App\Http\Controllers\Backend\WeightUnitController;
use Illuminate\Support\Facades\Route;

// All Admin Routes

Route::resource('sugar-units', SugarUnitController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
Route::resource('water-units', WaterUnitController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
Route::resource('weight-units', WeightUnitController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
Route::resource('feeling-lists', FeelingListController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
Route::resource('heart-rate-units', HeartRateUnitController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
Route::resource('blood-pressure-units', BloodPressureUnitController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
Route::resource('height-units', HeightUnitController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
Route::resource('medicine-units', MedicineUnitController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
