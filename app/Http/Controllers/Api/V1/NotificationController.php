<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Notification\NotificationRequest;
use App\Http\Resources\Notification\NotificationResource;
use App\Services\Api\Notification\NotificationService;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function show(int $profileId, Request $request): JsonResponse
    {
        $profile = Profile::find($profileId);

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found',
                'status' => 'error'
            ], 404);
        }

        $notification = $this->notificationService->getByProfile($profile);

        if (!$notification) {
            return response()->json([
                'message' => 'Notification settings not found',
                'status' => 'error'
            ], 404);
        }

        return ApiResponse::response(
            true,
            'Notification settings Retrive successfully',
            new NotificationResource($notification)
        );
    }

    public function update(int $profileId, NotificationRequest $request): JsonResponse
    {
        $profile = Profile::find($profileId);

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found',
                'status' => 'error'
            ], 404);
        }

        $notification = $this->notificationService->createOrUpdate(
            $profile,
            $request->validated()
        );

        return ApiResponse::response(
            true,
            'Notification settings updated successfully',
            new NotificationResource($notification)
        );
    }
}