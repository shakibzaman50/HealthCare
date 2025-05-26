<?php

use App\Http\Controllers\Admin\BloodOxygenController;
use App\Http\Controllers\Admin\BloodPressureController;
use App\Http\Controllers\Admin\Config\ActivityLevelController;
use App\Http\Controllers\Admin\Config\BlogController;
use App\Http\Controllers\Admin\Config\BsMeasurementTypeController;
use App\Http\Controllers\Admin\Config\BsRangeController;
use App\Http\Controllers\Admin\Config\BsRecordController;
use App\Http\Controllers\Admin\Config\FeelingListController;
use App\Http\Controllers\Admin\Config\HeightUnitController;
use App\Http\Controllers\Admin\Config\MedicationController;
use App\Http\Controllers\Admin\Config\MedicineScheduleController;
use App\Http\Controllers\Admin\Config\MedicineTypeController;
use App\Http\Controllers\Admin\Config\MedicineUnitController;
use App\Http\Controllers\Admin\Config\SugarScheduleController;
use App\Http\Controllers\Admin\Config\SugarUnitController;
use App\Http\Controllers\Admin\Config\WaterUnitController;
use App\Http\Controllers\Admin\Config\WeightUnitController;
use App\Http\Controllers\Admin\HydrationReminderController;
use App\Http\Controllers\GlobalSettingsController;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MigrationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\Admin\Config\PhysicalConditionsController;
use App\Http\Controllers\Admin\Config\HeartRateUnitsController;
use App\Http\Controllers\Admin\Config\BpUnitsController;
use App\Http\Controllers\Admin\HeartRateController;
use App\Http\Controllers\Admin\LoginInfoController;
use App\Http\Controllers\Admin\UserProfileController;

// Public Routes
Route::get('/', [HomePage::class, 'index'])->name('pages-home');
Route::get('/cache/clear', [HomePage::class, 'allCacheClear'])->name('cache-clear');

// Auth Pages
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
  // Dashboard & Utilities
  Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
  Route::get('refresh', [HomeController::class, 'refresh'])->name('refresh');

  // Profile & Password
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::get('password/reset', [PasswordController::class, 'edit'])->name('password.edit');
  Route::post('update/password', [PasswordController::class, 'updatePassword'])->name('update.password');

  // User Profiles Management Routes
  Route::prefix('user-profiles')->group(function () {
    Route::get('/', [UserProfileController::class, 'index'])->name('user-profiles.index');
    Route::get('/search', [UserProfileController::class, 'search'])->name('user-profiles.search');
    Route::get('/{user}/profiles', [UserProfileController::class, 'showProfiles'])->name('user-profiles.show');
    Route::get('/{user}/profiles/{profile}', [UserProfileController::class, 'showProfileDetails'])->name('user-profiles.details');
  });

  // Admin Login Info
  Route::prefix('admin/logininfo')->group(function () {
    Route::get('/', [LoginInfoController::class, 'admin'])->name('admin.logininfo');
    Route::get('/data', [LoginInfoController::class, 'admindata'])->name('admin.logininfo.data');
  });
  // User Login Info
  Route::prefix('user/logininfo')->group(function () {
    Route::get('/', [LoginInfoController::class, 'user'])->name('user.logininfo');
    Route::get('/data', [LoginInfoController::class, 'userdata'])->name('user.logininfo.data');
  });

  // Activity Logs
  Route::get('activity-log', [ActivityLogController::class, 'activityLog'])->name('userBehave-activity-log');
  Route::get('admin-login-log', [ActivityLogController::class, 'adminLogingLog'])->name('logingInfo-adminLoging-Log');

  // Resource Routes
  Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
    'permissions' => PermissionController::class,

    'physical-conditions' => PhysicalConditionsController::class,
    'heart-rate-units' => HeartRateUnitsController::class,
    'bp-units' => BpUnitsController::class,
    'global_settings' => GlobalSettingsController::class,

    'blogs' => BlogController::class,
    'sugar-units' => SugarUnitController::class,
    'water-units' => WaterUnitController::class,
    'weight-units' => WeightUnitController::class,
    'height-units' => HeightUnitController::class,
    'feeling-lists' => FeelingListController::class,
    'medicine-units' => MedicineUnitController::class,
    'medicine-types' => MedicineTypeController::class,
    'sugar-schedules' => SugarScheduleController::class,
    'activity-levels' => ActivityLevelController::class,
    'medicine-schedules' => MedicineScheduleController::class,
  ]);

  // Heart Rate Routes
  Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('heart-rates', [HeartRateController::class, 'index'])->name('heart-rates.index');
    Route::delete('heart-rates/{id}', [HeartRateController::class, 'destroy'])->name('heart-rates.destroy');
    Route::post('heart-rates/bulk-delete', [HeartRateController::class, 'bulkDelete'])->name('heart-rates.bulk-delete');
  });

  Route::prefix('admin')->name('admin.')->group(function () {
    // Heart Rate Routes
    Route::get('heart-rates', [HeartRateController::class, 'index'])->name('heart-rates.index');
    Route::delete('heart-rates/{id}', [HeartRateController::class, 'destroy'])->name('heart-rates.destroy');
    Route::post('heart-rates/bulk-delete', [HeartRateController::class, 'bulkDelete'])->name('heart-rates.bulk-delete');

    // Blood Oxygen Routes
    Route::resource('blood-oxygens', BloodOxygenController::class)->only(['index', 'destroy']);
    Route::group(['prefix' => 'blood-oxygens', 'as' => 'blood-oxygens.', 'controller' => BloodOxygenController::class], function () {
      Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Blood Pressure Routes
    Route::resource('blood-pressures', BloodPressureController::class)->only(['index', 'destroy']);
    Route::group(['prefix' => 'blood-pressures', 'as' => 'blood-pressures.', 'controller' => BloodPressureController::class], function () {
      Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Hydration Routes
    Route::resource('hydration-reminders', HydrationReminderController::class)->only(['index', 'destroy']);
    Route::group(['prefix' => 'hydration-reminders', 'as' => 'hydration-reminders.', 'controller' => HydrationReminderController::class], function () {
      Route::post('bulk-delete', 'bulkDelete')->name('bulk-delete');
    });

    // Blood Sugar Routes
  Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('bs-records', [BsRecordController::class, 'index'])->name('bs-records.index');
    Route::post('bs-records/store', [BsRecordController::class, 'store'])->name('bs-records.store');
    Route::delete('bs-records/{id}', [BsRecordController::class, 'destroy'])->name('bs-records.destroy');
    Route::post('bs-records/bulk-delete', [BsRecordController::class, 'bulkDelete'])->name('bs-records.bulk-delete');
    Route::get('bs-records/bulk-export', [BsRecordController::class, 'exportToCsv'])->name('bs-records.bulk-export');
  });

  // Medication Routes
  Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('medications', [MedicationController::class, 'index'])->name('medications.index');
    Route::get('medications/{medicine}', [MedicationController::class, 'show'])->name('medications.show')->where('medicine', '[0-9]+');
    Route::post('medications/store', [MedicationController::class, 'store'])->name('medications.store');
    Route::delete('medications/{id}', [MedicationController::class, 'destroy'])->name('medications.destroy');
    Route::post('medications/bulk-delete', [MedicationController::class, 'bulkDelete'])->name('medications.bulk-delete');
    Route::get('medications/bulk-export', [MedicationController::class, 'exportToCsv'])->name('medications.bulk-export');
  });

  });
  Route::post('/admin/upload-image', [App\Http\Controllers\Admin\ImageUploadController::class, 'upload'])->name('admin.upload.image');
});
require __DIR__ . '/auth.php';
