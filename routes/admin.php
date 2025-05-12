<?php

use App\Http\Controllers\Backend\FellingListController;
use App\Http\Controllers\Backend\SugarUnitController;
use App\Http\Controllers\Backend\WaterUnitController;
use App\Http\Controllers\Backend\WeightUnitController;
use Illuminate\Support\Facades\Route;

// All Admin Routes

Route::resource('sugar-units', SugarUnitController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
Route::resource('water-units', WaterUnitController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
Route::resource('weight-units', WeightUnitController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
Route::resource('feeling-lists', FellingListController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
