<?php

namespace App\Http\Controllers\Api\V1;

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

        return response()->json([
            'data' => new NotificationResource($notification),
            'status' => 'success'
        ]);
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

        return response()->json([
            'data' => new NotificationResource($notification),
            'message' => 'Notification settings updated successfully',
            'status' => 'success'
        ]);
    }
}