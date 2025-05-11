<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\LoginInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LoginInfoController extends Controller
{
    public function admin()
    {
        return view('admin.logininfo.admin');
    }
    public function user()
    {
        return view('admin.logininfo.user');
    }

    public function admindata()
    {
        $info = LoginInfo::where('user_type', 'admin')->with('user');

        return DataTables::of($info)
            ->make(true);
    }

    public function userdata()
    {
        $info = LoginInfo::where('user_type', 'customer')->with('user');

        return DataTables::of($info)
            ->make(true);
    }
}
