<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->status == 1) {
            return $next($request);
        }
        return response()->json([
            'success' => false,
            'data'    => null,
            'error'   => 'This user profile is Inactive.'
        ], 403);
    }
}
