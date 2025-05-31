<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WaterIntake\ChartRequest;
use App\Http\Requests\Api\WaterIntake\ExportRequest;
use App\Http\Requests\Api\WaterIntake\FilterRequest;
use App\Http\Requests\Api\WaterIntake\StoreRequest;
use App\Models\WaterIntake;
use App\Services\Api\WaterIntakeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WaterIntakeController extends Controller
{
    protected $waterIntakeService, $profileId;

    public function __construct(Request $request)
    {
        $this->profileId          = $request->route('profile_id');
        $this->waterIntakeService = new WaterIntakeService($this->profileId);
    }

    public function index()
    {
        try {
            $records = $this->waterIntakeService->history();
            return ApiResponse::response(true, 'Water Intake history successfully fetched.', $records);
        } catch (\Exception $e) {
            Log::error('Water Intake history fetch failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function latestRecord()
    {
        try {
            $latestRecord = $this->waterIntakeService->latestRecord();
            return ApiResponse::response(true, 'Latest Water Intake successfully fetched.', $latestRecord);
        } catch (\Exception $e) {
            Log::error('Latest Water Intake fetch failed: ' . $e->getMessage());
            return ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $newRecord = $this->waterIntakeService->store($request);
            return ApiResponse::response(true, 'Water Intake successfully stored.', $newRecord);
        } catch (\Exception $e) {
            Log::error('Water Intake Create failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($profileId, string $id)
    {
        try {
            $record = WaterIntake::findOrFail($id);

            if ($record->profile_id != $this->profileId) {
                return ApiResponse::response(false, 'You are not authorized to delete this record.');
            }

            $this->waterIntakeService->delete($record);
            return ApiResponse::response(true, 'Water Intake was successfully deleted.');
        } catch (\Exception $e) {
            Log::error('Water Intake Delete failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function chartData(ChartRequest $request)
    {
        try {
            $records = $this->waterIntakeService->RecordByDate($request->date);
            return ApiResponse::response(true, 'Water Intake chart data successfully fetched.', $records);
        } catch (\Exception $e) {
            Log::error('Water Intake chart data fetch failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function filter(FilterRequest $request)
    {
        try {
            $records = $this->waterIntakeService->filter($request);
            return ApiResponse::response(true, 'Water Intake successfully filtered.', $records);
        } catch (\Exception $e) {
            Log::error('Water Intake filter failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function export(ExportRequest $request)
    {
        try {
            return $this->waterIntakeService->export($request);
        } catch (\Exception $e) {
            Log::error('Water Intake export failed: ' . $e->getMessage());
            return ApiResponse::serverError($e->getMessage());
        }
    }
}
