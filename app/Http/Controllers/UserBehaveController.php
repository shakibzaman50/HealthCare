<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserBehaveController extends Controller
{
    public function onlineUser()
    {
        return view('online_user.index');
    }
}
