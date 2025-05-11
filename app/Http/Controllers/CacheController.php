<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
{
    public function clearAllCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('event:clear');
        return redirect()->back()->with('success', 'All caches have been cleared!');
    }
}
