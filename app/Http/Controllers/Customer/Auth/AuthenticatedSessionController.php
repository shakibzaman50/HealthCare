<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CustomerLoginRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\AuthenticatiinEmail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Nette\Utils\Random;

class AuthenticatedSessionController extends Controller
{
  /**
   * Display the login view.
   */
  public function create(): View
  {
    return view('customer.auth.login');
  }

  /**
   * Handle an incoming authentication request.
   */
  public function store(CustomerLoginRequest $request): RedirectResponse
  {
    $request->authenticate();
    Auth::guard('customer')->login(Auth::guard('customer')->user(), true);
    $request->session()->regenerate();

    $request->session()->regenerate();
    $customer = Auth::guard('customer')->user();
    $user = User::where('id', $customer->user_id)->first();

    Session::put('locale', $user->locale);
    App::setLocale($user->locale);
    if (Auth::guard('customer')->user()->auth_2fa) {
      $code = str()->random(6);
      $currentDateTime = date('Y-m-d H:i:s');
      $expire_at = date('Y-m-d H:i:s', strtotime('+15 minutes', strtotime($currentDateTime)));
      $customer->update([
        'two_factor_code' => $code,
        'two_factor_code_expire_at' => $expire_at
      ]);
      Mail::to($customer->email)->send(new AuthenticatiinEmail($code));
    }
    return redirect()->intended(route('customer.dashboard', absolute: false));
  }

  /**
   * Destroy an authenticated session.
   */
  public function destroy(Request $request): RedirectResponse
  {
    //        dd($request->all());
    Auth::guard('customer')->logout();
    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
  }
}
