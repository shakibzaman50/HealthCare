<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    public function handle(Login $event)
    {
//        dd($event->guard);
        // Cast the Authenticatable instance to the actual User model

        $user = $event->user;

        if ($event->guard == 'customer') {

            $role = 'customer';
        } else {
            $role = 'admin';
        }
        if ($user) {
            info('User is ', [$user->type]);
            $ipAddress = Request::ip();
            activity()
                ->causedBy($user) // This now expects a Model instance
                ->withProperties([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip' => $ipAddress,
                    'role' => $role,
                    'browser' => request()->userAgent()
                ])
                ->log("User {$user->email} (ID: {$user->id}) logged In");
        }
    }
}
