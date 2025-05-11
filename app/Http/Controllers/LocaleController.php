<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setLocale($locale)
    {
        if (Auth::user()) {
            $user = User::where('id', Auth::user()->id)->first();
        } else {
            $user = User::where('id', Auth::guard('customer')->user()->id)->first();
        }

        if ($user->locale != $locale) {
            $availableLocales = ['en', 'ru', 'bn', 'hi', 'ur', 'ne', 'si', 'tr', 'be'];

            if (in_array($locale, $availableLocales)) {
                Session::put('locale', $locale);
                $user->locale = $locale;
                $user->save();
                // $request->session()->put('locale', $locale);
                App::setLocale($locale);
            }
            info('Local is ', [$locale]);
        }
        return redirect()->back()->with('success', 'Language Is Updated Successfully');
    }
}
