<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MedicineResource;
use App\Http\Resources\MedicineReminderResource;
use App\Services\Api\MedicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MedicationController extends Controller
{
    protected $medicationService;

    public function __construct(MedicationService $medicationService)
    {
        $this->medicationService = $medicationService;
    }

    public function index(Request $request)
    {
        try {
            $profileId = $request->get('profile_id');
            $medicines = $this->medicationService->getAllMedicines($profileId);

            return ApiResponse::response(
                true,
                'Medicines successfully fetched.',
                MedicineResource::collection($medicines)
            );
        } catch (\Exception $e) {
            Log::error('Medicine fetch failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'profile_id' => 'required|exists:profiles,id',
                'name' => 'required|string|max:255',
                'type' => 'required|exists:medicine_types,id',
                'strength' => 'required|integer|min:1',
                'unit' => 'required|exists:medicine_units,id',
                'is_active' => 'boolean',
                'notes' => 'nullable|string',
                'reminders' => 'array',
                'reminders.*.end_date' => 'nullable|date',
                'reminders.*.is_repeat' => 'boolean',
                'reminders.*.till_turn_off' => 'boolean',
                'reminders.*.schedules' => 'array',
                'reminders.*.schedules.*.schedule_type' => 'required|string',
                'reminders.*.schedules.*.how_many_times' => 'nullable|integer|min:1',
                'reminders.*.schedules.*.times' => 'array',
                'reminders.*.schedules.*.times.*.time' => 'required|date_format:H:i',
                'reminders.*.schedules.*.times.*.label' => 'nullable|string|max:255',
                'reminders.*.schedules.*.times.*.is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                return ApiResponse::response(false, 'Validation failed.', $validator->errors(), 422);
            }

            $medicine = $this->medicationService->storeMedicine($request->all());

            return ApiResponse::response(
                true,
                'Medicine was successfully created.',
                new MedicineResource($medicine),
                201
            );
        } catch (\Exception $e) {
            Log::error('Medicine create failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function show(string $id)
    {
        try {
            $medicine = $this->medicationService->getMedicine($id);

            return ApiResponse::response(
                true,
                'Medicine successfully fetched.',
                new MedicineResource($medicine)
            );
        } catch (\Exception $e) {
            Log::error('Medicine show failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'profile_id' => 'exists:profiles,id',
                'name' => 'string|max:255',
                'type' => 'exists:medicine_types,id',
                'strength' => 'integer|min:1',
                'unit' => 'exists:medicine_units,id',
                'is_active' => 'boolean',
                'notes' => 'nullable|string',
                'reminders' => 'array',
                'reminders.*.end_date' => 'nullable|date',
                'reminders.*.is_repeat' => 'boolean',
                'reminders.*.till_turn_off' => 'boolean',
                'reminders.*.schedules' => 'array',
                'reminders.*.schedules.*.schedule_type' => 'required|string',
                'reminders.*.schedules.*.how_many_times' => 'nullable|integer|min:1',
                'reminders.*.schedules.*.times' => 'array',
                'reminders.*.schedules.*.times.*.time' => 'required|date_format:H:i',
                'reminders.*.schedules.*.times.*.label' => 'nullable|string|max:255',
                'reminders.*.schedules.*.times.*.is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                return ApiResponse::response(false, 'Validation failed.', $validator->errors(), 422);
            }

            $medicine = $this->medicationService->updateMedicine($id, $request->all());

            return ApiResponse::response(
                true,
                'Medicine was successfully updated.',
                new MedicineResource($medicine)
            );
        } catch (\Exception $e) {
            Log::error('Medicine update failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->medicationService->deleteMedicine($id);

            return ApiResponse::response(true, 'Medicine was successfully deleted.');
        } catch (\Exception $e) {
            Log::error('Medicine delete failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function reminders(Request $request)
    {
        try {
            $profileId = $request->get('profile_id');
            $reminders = $this->medicationService->getActiveReminders($profileId);

            return ApiResponse::response(
                true,
                'Medicine reminders successfully fetched.',
                MedicineReminderResource::collection($reminders)
            );
        } catch (\Exception $e) {
            Log::error('Medicine reminders fetch failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function medicinesByProfile(Request $request, string $profileId)
    {
        try {
            $medicines = $this->medicationService->getMedicinesByProfile($profileId);

            return ApiResponse::response(
                true,
                'Profile medicines successfully fetched.',
                MedicineResource::collection($medicines)
            );
        } catch (\Exception $e) {
            Log::error('Profile medicines fetch failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }
}