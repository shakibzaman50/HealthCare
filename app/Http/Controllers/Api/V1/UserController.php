<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Requests\Api\User\UpdatePasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Api\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\FlareClient\Api;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(Request $request)
    {
        $user = $this->userService->getUserWithProfiles($request->user()->id);
        return ApiResponse::response(
            true,
            'User details retrieved successfully',
            new UserResource($user)
        );
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $this->userService->updateUser($request->user(), $request->validated());
        return ApiResponse::response(
            true,
            'User updated successfully',
            new UserResource($user)
        );
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $this->userService->updatePassword($request->user(), $request->password);

        // Revoke all tokens
        $user->tokens()->delete();

        return ApiResponse::response(
            true,
            'Password updated successfully. Please login again.'
        );
        return $this->successResponse(
            null,
            'Password updated successfully. Please login again.'
        );
    }
}
