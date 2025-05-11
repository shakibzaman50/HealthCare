<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Logout;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Request;
use App\Models\User;

class LogSuccessfulLogout
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
    public function handle(Logout $event)
    {
        // Cast the Authenticatable instance to the actual User model
        $user = $event->user instanceof User ? $event->user : null;

        if ($user) {
            $ipAddress = Request::ip();
            activity()
                ->causedBy($user)
                ->withProperties([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip' => $ipAddress
                ]) // Log extra properties (user id and email)
                ->log("User {$user->email} (ID: {$user->id}) logged out");
        }
    }
}
