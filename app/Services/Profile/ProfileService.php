<?php

namespace App\Services\Profile;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileService
{
    public function list()
    {
        return Profile::with('user')->latest()->get();
    }

    public function store(array $data)
    {
        return Profile::create($data);
    }

    public function update(Profile $profile, array $data)
    {
        $profile->update($data);
        return $profile;
    }

    public function delete(Profile $profile)
    {
        return $profile->delete();
    }

    public function restore(int $id)
    {
        return Profile::withTrashed()->findOrFail($id)->restore();
    }
}
