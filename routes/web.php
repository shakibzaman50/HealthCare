<?php

use App\Http\Controllers\GlobalSettingsController;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MigrationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;

// Main Page Route
Route::get('/', [HomePage::class, 'index'])->name('pages-home');
Route::get('/cache/clear', [HomePage::class, 'allCacheClear'])->name('cache-clear');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/clear-cache', [CacheController::class, 'clearAllCache'])->name('clear.cache');


Route::middleware(['auth', 'verified', 'web'])->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  Route::resource('roles', RoleController::class);
  Route::resource('users', UserController::class);
  Route::resource('permissions', PermissionController::class);
});

Route::middleware(['auth', 'verified'])->group(function () {

  Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
  Route::get('/export-database', [MigrationController::class, 'export'])->name('database.export');
  Route::get('/database-migration', [MigrationController::class, 'showImportForm'])->name('import.database.form');
  Route::post('/import-database', [MigrationController::class, 'importDatabase'])->name('import.database');
  Route::get('admin/logininfo', [\App\Http\Controllers\Admin\LoginInfoController::class, 'admin'])->name('admin.logininfo');
  Route::get('admin/logininfo/data', [\App\Http\Controllers\Admin\LoginInfoController::class, 'admindata'])->name('admin.logininfo.data');
  Route::get('user/logininfo', [\App\Http\Controllers\Admin\LoginInfoController::class, 'user'])->name('user.logininfo');
  Route::get('user/logininfo/data', [\App\Http\Controllers\Admin\LoginInfoController::class, 'userdata'])->name('user.logininfo.data');
  Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->names('manage-member-customers');
  Route::get('admin/users-datatable', [\App\Http\Controllers\Admin\CustomerController::class, 'datatable'])->name('users.datatable');

  Route::get('users/banned', [\App\Http\Controllers\Admin\CustomerController::class, 'banned'])->name('users.banned');
  Route::get('users/users-banned', [\App\Http\Controllers\Admin\CustomerController::class, 'bannedData'])->name('users.bannedData');
  Route::get('users/email-unverified', [\App\Http\Controllers\Admin\CustomerController::class, 'emailUnverified'])->name('manage-member-customer-emailUnverified');
  Route::get('users/users-email-unverified', [\App\Http\Controllers\Admin\CustomerController::class, 'emailUnverifiedData'])->name('users.emailUnverifiedData');
  Route::get('users/number-unverified', [\App\Http\Controllers\Admin\CustomerController::class, 'numberUnverified'])->name('manage-member-customer-numberUnverified');
  Route::get('users/users-number-unverified', [\App\Http\Controllers\Admin\CustomerController::class, 'numberUnverifiedData'])->name('users.numberUnverifiedData');

  Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::get('password/reset', [PasswordController::class, 'edit'])->name('password.edit');
  Route::post('update/password', [PasswordController::class, 'updatePassword'])->name('update.password');

  Route::get('activity-log', [ActivityLogController::class, 'activityLog'])->name('userBehave-activity-log');

  Route::get('admin-login-log', [ActivityLogController::class, 'adminLogingLog'])->name('logingInfo-adminLoging-Log');
  Route::get('customer-login-log', [ActivityLogController::class, 'customerLogingLog'])->name('logingInfo-customerLoging-Log');

  Route::resource('roles', RoleController::class);
  Route::resource('users', UserController::class);
  Route::resource('permissions', PermissionController::class);
});


Route::prefix('user')->middleware(['auth:customer', '2fa'])->group(function () {

  Route::get('dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

  Route::get('profile', [\App\Http\Controllers\Customer\CustomerController::class, 'profile'])->name('customer.profile');
});
Route::get('/2fa', [\App\Http\Controllers\Email2faController::class, 'create'])->name('customer.2fa')->middleware('auth:customer');
Route::post('/2fa', [\App\Http\Controllers\Email2faController::class, 'verify'])->name('customer.2fa.verify')->middleware('auth:customer');
Route::post('/2fa-resend', [\App\Http\Controllers\Email2faController::class, 'resend'])->name('customer.2fa.resend')->middleware('auth:customer');
Route::get('/set-locale/{locale}', [LocaleController::class, 'setLocale'])->name('set.locale');

require __DIR__ . '/auth.php';
require __DIR__ . '/customer-auth.php';

Route::group([
  'prefix' => 'global_settings',
], function () {
  Route::get('/', [GlobalSettingsController::class, 'index'])
    ->name('global_settings.global_setting.index');
  Route::get('/create', [GlobalSettingsController::class, 'create'])
    ->name('global_settings.global_setting.create');
  Route::get('/show/{globalSetting}', [GlobalSettingsController::class, 'show'])
    ->name('global_settings.global_setting.show')->where('id', '[0-9]+');
  Route::get('/{globalSetting}/edit', [GlobalSettingsController::class, 'edit'])
    ->name('global_settings.global_setting.edit')->where('id', '[0-9]+');
  Route::post('/', [GlobalSettingsController::class, 'store'])
    ->name('global_settings.global_setting.store');
  Route::put('global_setting/{globalSetting}', [GlobalSettingsController::class, 'update'])
    ->name('global_settings.global_setting.update')->where('id', '[0-9]+');
  Route::delete('/global_setting/{globalSetting}', [GlobalSettingsController::class, 'destroy'])
    ->name('global_settings.global_setting.destroy')->where('id', '[0-9]+');
});