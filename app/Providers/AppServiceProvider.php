<?php

namespace App\Providers;

use App\Models\GlobalSetting;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    // Avoid DB query during CLI or when DB isn't ready
    if (!app()->runningInConsole()) {
      view()->composer('*', function ($view) {
        try {
          $globalSetting = \App\Models\GlobalSetting::find(1);
          $cart = session()->get('cart', []);
          $view->with(compact('globalSetting', 'cart'));
        } catch (\Exception $e) {
          // Log or silently fail
          logger()->warning('GlobalSetting fetch failed: ' . $e->getMessage());
          $view->with('globalSetting', null)->with('cart', []);
        }
      });
    }

    // Gate definitions
    Gate::define('admin-menu', function () {
      $user = auth()->guard('web')->user();
      return $user && $user->type == 1;
    });

    Gate::define('customer-menu', function () {
      return auth()->guard('customer')->user();
    });

    // Vite CSS attribute handling
    Vite::useStyleTagAttributes(function (?string $src, string $url, ?array $chunk, ?array $manifest) {
      if ($src !== null) {
        if (preg_match("/(resources\/assets\/vendor\/scss\/(rtl\/)?core)-?.*/i", $src)) {
          return ['class' => 'template-customizer-core-css'];
        } elseif (preg_match("/(resources\/assets\/vendor\/scss\/(rtl\/)?theme)-?.*/i", $src)) {
          return ['class' => 'template-customizer-theme-css'];
        }
      }
      return [];
    });

    // Force HTTPS in production
    if ($this->app->environment('production')) {
      URL::forceScheme('https');
    }
  }
}
