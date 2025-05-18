<?php

namespace App\Http\Controllers\Admin\User\Profile;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\Profile\ProfileService;
use App\Http\Requests\Profile\StoreProfileRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Display a listing of profiles.
     */
    public function index(): JsonResponse
    {
        $profiles = $this->profileService->list();
        return response()->json($profiles);
    }

    /**
     * Store a newly created profile.
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {
        $profile = $this->profileService->store($request->validated());
        return response()->json($profile, 201);
    }

    /**
     * Display the specified profile.
     */
    public function show(Profile $profile): JsonResponse
    {
        return response()->json($profile);
    }

    /**
     * Update the specified profile.
     */
    public function update(UpdateProfileRequest $request, Profile $profile): JsonResponse
    {
        $updatedProfile = $this->profileService->update($profile, $request->validated());
        return response()->json($updatedProfile);
    }

    /**
     * Soft delete the specified profile.
     */
    public function destroy(Profile $profile): JsonResponse
    {
        $this->profileService->delete($profile);
        return response()->json(['message' => 'Profile soft deleted successfully']);
    }

    /**
     * Restore a soft-deleted profile.
     */
    public function restore(int $id): JsonResponse
    {
        $this->profileService->restore($id);
        return response()->json(['message' => 'Profile restored successfully']);
    }
}
