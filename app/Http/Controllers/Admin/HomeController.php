<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('roles');
        return view('admin.dashboard', compact('user'));
    }

    public function refresh()
    {
        Artisan::call('optimize:clear');
        return back()->with('success', 'Cache Clear');
    }
}
