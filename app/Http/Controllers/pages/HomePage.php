<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GlobalSetting;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Log;

class HomePage extends Controller
{
  protected const CACHE_TTL = 3600; // 1 hour

  public function index()
  {

    return view('auth.login');
  }
  public function allCacheClear()
  {
    Redis::flushall(); // Clear all data from Redis cache
    Artisan::call('optimize:clear');
    info('Cache Clear manually');
    return redirect()->back()->with('success', 'Cache Clear');
  }
}
