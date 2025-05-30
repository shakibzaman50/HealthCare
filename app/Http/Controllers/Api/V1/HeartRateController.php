<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\HeartRate\ChartRequest;
use App\Http\Requests\Api\HeartRate\FilterRequest;
use App\Http\Requests\Api\HeartRate\StoreRequest;
use App\Models\HeartRate;
use App\Services\Api\HeartRateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HeartRateController extends Controller
{
    protected $heartRateService, $profileId;

    public function __construct(Request $request)
    {
        $this->profileId = $request->route('profile_id');
        $this->heartRateService = new HeartRateService($this->profileId);
    }

    public function index(Request $request)
    {
        try {
            $records = $this->heartRateService->history();
            return ApiResponse::response(true, 'Heart Rate history successfully fetched.', $records);
        }
        catch (\Exception $e) {
            Log::error('Heart Rate history fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $latestRecord = $this->heartRateService->store($request);
            return ApiResponse::response(true, 'Heart Rate was successfully stored.', $latestRecord);
        }
        catch (\Exception $e) {
            Log::error('Heart Rate Create failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function latestRecord(){
        try {
            $latestRecord = $this->heartRateService->latestRecord();
            return ApiResponse::response(true, 'Latest Heart Rate successfully fetched.', $latestRecord);
        }
        catch (\Exception $e) {
            Log::error('Latest Heart Rate fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError($e->getMessage());
        }
    }

    public function destroy(string $profileId, $id)
    {
        try {
            $record = HeartRate::findOrFail($id);
            if ($record->profile_id != $this->profileId){
                return  ApiResponse::response(false, 'You are not authorized to delete this record.');
            }
            $this->heartRateService->delete($record);
            return ApiResponse::response(true, 'Heart Rate was successfully deleted.');
        }catch (\Exception $e) {
            Log::error('Heart Rate Delete failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function chartData(ChartRequest $request)
    {
        try {
            $records = $this->heartRateService->RecordByDate($request->date);
            return ApiResponse::response(true, 'Heart Rate chart data successfully fetched.', $records);
        } catch (\Exception $e) {
            Log::error('Heart Rate chart data fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function lastWeekAverage()
    {
        try {
            $records = $this->heartRateService->lastWeekAverageRecord();
            return ApiResponse::response(true, 'Heart Rate Last week average successfully fetched.', $records);
        }
        catch (\Exception $e) {
            Log::error('Heart Rate Last week average fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function filter(FilterRequest $request)
    {
        try {
            $records = $this->heartRateService->filter($request);
            return ApiResponse::response(true, 'Heart Rate successfully filtered.', $records);
        }
        catch (\Exception $e) {
            Log::error('Heart Rate filter failed: ' . $e->getMessage());
            return  ApiResponse::serverError($e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $records = $this->heartRateService->export($request);
            return ApiResponse::response(true, 'Heart Rate successfully exported.',$records);
        }catch (\Exception $e) {
            Log::error('Heart Rate export failed: ' . $e->getMessage());
            return  ApiResponse::serverError($e->getMessage());
        }
    }
}
