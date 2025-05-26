<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BloodOxygen\ChartRequest;
use App\Http\Requests\Api\BloodOxygen\ExportRequest;
use App\Http\Requests\Api\BloodOxygen\FilterRequest;
use App\Http\Requests\Api\BloodOxygen\StoreRequest;
use App\Models\BloodOxygen;
use App\Services\Api\BloodOxygenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BloodOxygenController extends Controller
{
    protected $bloodOxygenService, $profileId;

    public function __construct(Request $request)
    {
        $this->profileId = $request->route('profile_id');
        $this->bloodOxygenService = new BloodOxygenService($this->profileId);
    }

    public function index()
    {
        try {
            $records = $this->bloodOxygenService->history();
            return ApiResponse::response(true, 'Blood Oxygen history successfully fetched.', $records);
        }catch (\Exception $e) {
            Log::error('Blood Oxygen history fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function latestRecord(){
        try {
            $latestRecord = $this->bloodOxygenService->latestRecord();
            return ApiResponse::response(true, 'Latest Blood Oxygen successfully fetched.', $latestRecord);
        }
        catch (\Exception $e) {
            Log::error('Latest Blood Oxygen fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError($e->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $newRecord = $this->bloodOxygenService->store($request);
            return ApiResponse::response(true, 'Blood Oxygen was successfully stored.', $newRecord);
        }
        catch (\Exception $e) {
            Log::error('Blood Oxygen Create failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function destroy(string $profileId, $id)
    {
        try {
            $record = BloodOxygen::findOrFail($id);

            if ($record->profile_id != $this->profileId){
                return  ApiResponse::response(false, 'You are not authorized to delete this record.');
            }

            $this->bloodOxygenService->delete($record);
            return ApiResponse::response(true, 'Blood Oxygen was successfully deleted.');
        }catch (\Exception $e) {
            Log::error('Blood Oxygen Delete failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function chartData(ChartRequest $request)
    {
        try {
            $records = $this->bloodOxygenService->RecordByDate($request->date);
            return ApiResponse::response(true, 'Blood Oxygen chart data successfully fetched.', $records);
        } catch (\Exception $e) {
            Log::error('Blood Oxygen chart data fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function lastWeekAverage()
    {
        try {
            $records = $this->bloodOxygenService->lastWeekAverageRecord();
            return ApiResponse::response(true, 'Blood Oxygen Last week average successfully fetched.', $records);
        }catch (\Exception $e) {
            Log::error('Blood Oxygen Last week average fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function filter(FilterRequest $request)
    {
        try {
            $records = $this->bloodOxygenService->filter($request);
            return ApiResponse::response(true, 'Blood Oxygen successfully filtered.', $records);
        } catch (\Exception $e) {
            Log::error('Blood Oxygen filter failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function export(ExportRequest $request)
    {
        try {
            $records = $this->bloodOxygenService->export($request);
            return ApiResponse::response(true, 'Blood Oxygen successfully exported.',$records);
        } catch (\Exception $e) {
            Log::error('Blood Oxygen export failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }
}
