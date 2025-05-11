<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('auth.login', ['pageConfigs' => $pageConfigs]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        logger('Here ``1');
        Auth::login(Auth::user(), true);
        logger('Here ``2');

        $user = User::where('id', Auth::user()->id)->first();
        logger('Here ``3');

        $request->session()->regenerate();
        logger('Here ``4');

        Session::put('locale', $user->locale);
        App::setLocale($user->locale);
        logger('Here ``5');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
