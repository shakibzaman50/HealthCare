<?php

namespace App\Http\Controllers;

use App\Mail\AuthenticatiinEmail;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Email2faController extends Controller
{
  use ValidatesRequests;

  public function create()
  {
    $user = auth()->guard('customer')->user();
    if ($user->auth_2fa && $user->two_factor_code) {
      $pageConfigs = ['myLayout' => 'blank'];
      return view('customer.auth.twofa', ['pageConfigs' => $pageConfigs]);
    } else {
      return redirect()->route('customer.dashboard');
    }
  }

  public function verify(Request $request)
  {
    $this->validate($request, [
      'code' => 'required',
    ]);
    $user = auth()->guard('customer')->user();
    if ($user->two_factor_code == $request->code) {
      $user->update([
        'two_factor_code' => null
      ]);
    } else {
      return redirect()->back()->withErrors('Invalid 2FA code');
    }
    return redirect()->route('customer.dashboard');
  }

  public function resend(Request $request)
  {
    $user = auth()->guard('customer')->user();
    $code = str()->random(6);
    $currentDateTime = date('Y-m-d H:i:s');
    $expire_at = date('Y-m-d H:i:s', strtotime('+15 minutes', strtotime($currentDateTime)));
    $user->update([
      'two_factor_code' => $code,
      'two_factor_code_expire_at' => $expire_at
    ]);
    Mail::to($user->email)->send(new AuthenticatiinEmail($code));
    return redirect()->back()->with('success', '2FA code has been sent to your registered email address');
  }
}
