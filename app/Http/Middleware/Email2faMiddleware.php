<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Email2faMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      if(auth()->guard('customer')->user()->auth_2fa && auth()->guard('customer')->user()->two_factor_code != null)
      {
        return redirect()->route('customer.2fa');
      }
      else{
        return $next($request);
      }
    }
}
