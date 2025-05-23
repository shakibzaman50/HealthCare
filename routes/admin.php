<?php

use App\Http\Controllers\Admin\ImageController;
use Illuminate\Support\Facades\Route;

// All Admin Config Routes

Route::post('/upload-editor-image', [ImageController::class, 'store']);
