<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReminderNotification\ReminderNotificationRequest;
use App\Http\Resources\ReminderNotification\NotificationReminderResource;
use App\Services\Api\ReminderNotification\ReminderNotificationService;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReminderNotificationController extends Controller
{
    protected $reminderNotificationService;

    public function __construct(ReminderNotificationService $reminderNotificationService)
    {
        $this->reminderNotificationService = $reminderNotificationService;
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

        $reminderNotification = $this->reminderNotificationService->getByProfile($profile);

        if (!$reminderNotification) {
            return response()->json([
                'message' => 'Reminder notification settings not found',
                'status' => 'error'
            ], 404);
        }

        return ApiResponse::response(
            true,
            'Profiles Reminder notification retrieved successfully',
            new NotificationReminderResource($reminderNotification)
        );
    }

    public function update(int $profileId, ReminderNotificationRequest $request): JsonResponse
    {
        $profile = Profile::find($profileId);

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found',
                'status' => 'error'
            ], 404);
        }

        $reminderNotification = $this->reminderNotificationService->createOrUpdate(
            $profile,
            $request->validated()
        );

        return ApiResponse::response(
            true,
            'Profiles Reminder notification settings updated successfully',
            new NotificationReminderResource($reminderNotification)
        );
    }
}