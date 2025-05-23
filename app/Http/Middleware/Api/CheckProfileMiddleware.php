<?php

namespace App\Http\Middleware\Api;

use App\Models\Profile;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $profileId = $request->route('profile_id');
        $profileId = (int) $profileId;
        if (Profile::where([
            'id'      => $profileId,
            'user_id' => Auth::id()
        ])->doesntExist()
        ) {
            return response()->json([
                'success' => false,
                'data'    => null,
                'error'   => 'Invalid Profile ID'
            ]);
        }
        return $next($request);
    }
}
