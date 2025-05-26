<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        $users = User::where('type', config('app.user_role.user'))->with('profiles')->get();
        return view('admin.user-profiles.index', compact('users'));
    }

    public function showProfiles(User $user)
    {
        $profiles = $user->profiles;
        return view('admin.user-profiles.profiles', compact('user', 'profiles'));
    }

    public function showProfileDetails(User $user, Profile $profile)
    {
        // Load all necessary relationships
        $profile->load([
            'assessment.activityLevel',
            'assessment.physicalCondition',
            'weightUnit',
            'heightUnit',
            'bloodPressures.unit',
            'bloodOxygens',
            'heartRates.unit',
            'hydrationReminders.unit'
        ]);

        return view('admin.user-profiles.details', compact('user', 'profile'));
    }
}
