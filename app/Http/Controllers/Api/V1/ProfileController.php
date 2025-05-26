<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\ProfileRequest;
use App\Http\Resources\Profile\ProfileCollection;
use App\Http\Resources\Profile\ProfileResource;
use App\Services\Api\Profile\ProfileService;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function allProfile(): JsonResponse
    {
        try {
            $profiles = $this->profileService->getAllProfiles();
            return ApiResponse::response(
                true,
                'Profiles retrieved successfully',
                new ProfileCollection($profiles)
            );
        } catch (Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $request->file('avatar');
            }

            $profile = $this->profileService->createProfile($data);
            return ApiResponse::response(
                true,
                'Profile created successfully',
                new ProfileResource($profile),
                null,
                201
            );
        } catch (Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $profile = $this->profileService->getProfileById($id);

            // Check if the profile belongs to the authenticated user
            if ($profile->user_id !== Auth::id()) {
                return ApiResponse::response(
                    false,
                    'Unauthorized access',
                    null,
                    'You do not have permission to access this profile',
                    403
                );
            }

            return ApiResponse::response(
                true,
                'Profile retrieved successfully',
                new ProfileResource($profile)
            );
        } catch (Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, string $id): JsonResponse
    {
        try {

            $profile = $this->profileService->getProfileById($id);

            // Check if the profile belongs to the authenticated user
            if ($profile->user_id !== Auth::id()) {
                return ApiResponse::response(
                    false,
                    'Unauthorized access',
                    null,
                    'You do not have permission to update this profile',
                    403
                );
            }

            $data = $request->validated();

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $request->file('avatar');
            }

            $profile = $this->profileService->updateProfile($id, $data);
            return ApiResponse::response(
                true,
                'Profile updated successfully',
                new ProfileResource($profile)
            );
        } catch (Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $profile = $this->profileService->getProfileById($id);

            // Check if the profile belongs to the authenticated user
            if ($profile->user_id !== Auth::id()) {
                return ApiResponse::response(
                    false,
                    'Unauthorized access',
                    null,
                    'You do not have permission to delete this profile',
                    403
                );
            }

            $this->profileService->deleteProfile($id);
            return ApiResponse::response(
                true,
                'Profile deleted successfully'
            );
        } catch (Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }
    public function getProfile($profileId) {}
}
