<?php

// app/Listeners/LogUserLogin.php

namespace App\Listeners;

use App\Models\LoginInfo;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class LogUserLogin
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Login $event): void
    {
        // Capture the user's IP address
        $ipAddress = $this->request->ip();

        // Capture browser info from the User-Agent string
        $userAgent = $this->request->header('User-Agent');
        $browser = $this->getBrowser($userAgent);

        if (isset($event->user->type)){
            $usertype = $event->user->type;
            $userid = $event->user->id;
        }
        else{
            $usertype = 'customer';
            $userid = $event->user->user_id;
        }
        // Log the user's login details
        LoginInfo::create([
            'user_id' => $userid,
            'user_type' => $usertype, // Assuming 'type' exists in the user model
            'ip_address' => $ipAddress,
            'browser' => $browser,
        ]);
    }

    // Extract browser name from User-Agent string
    protected function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
            return 'Internet Explorer';
        } elseif (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) {
            return 'Opera';
        }

        return 'Unknown';
    }
}

