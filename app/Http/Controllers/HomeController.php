<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function App\Helpers\createTransaction;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}