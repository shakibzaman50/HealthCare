<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BloodPressure\StoreRequest;
use App\Models\BloodPressure;
use App\Services\Api\BloodPressureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BloodPressureController extends Controller
{
    protected $bloodPressureService, $profileId;

    public function __construct(Request $request)
    {
        $this->profileId = $request->route('profile_id');
        $this->bloodPressureService = new BloodPressureService($this->profileId);
    }

    public function index()
    {
        try {
            $records = $this->bloodPressureService->history();
            return ApiResponse::response(true, 'Blood Pressure history successfully fetched.', $records);
        }catch (\Exception $e) {
            Log::error('Blood Pressure history fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function latestRecord(){
        try {
            $latestRecord = $this->bloodPressureService->latestRecord();
            return ApiResponse::response(true, 'Latest Blood Pressure successfully fetched.', $latestRecord);
        }
        catch (\Exception $e) {
            Log::error('Latest Blood Pressure fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError($e->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $newRecord = $this->bloodPressureService->store($request);
            return  ApiResponse::response(true, 'Blood Pressure was successfully stored.', $newRecord);
        }
        catch (\Exception $e) {
            Log::error('Blood Pressure Create failed: ' . $e->getMessage());
            return  ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $record = BloodPressure::findOrFail($id);

            if ($record->profile_id != $this->profileId){
                return  ApiResponse::response(false, 'You are not authorized to delete this record.');
            }

            $this->bloodPressureService->delete($record);
            return ApiResponse::response(true, 'Blood Pressure was successfully deleted.');
        } catch (\Exception $e) {
            Log::error('Blood Pressure Delete failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function chartData(Request $request)
    {
        try {
            $records = $this->bloodPressureService->RecordByDate($request->date);
            return ApiResponse::response(true, 'Blood Pressure chart data successfully fetched.', $records);
        }catch (\Exception $e) {
            Log::error('Blood Pressure chart data fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function lastWeekAverage()
    {
        try {
            $records = $this->bloodPressureService->lastWeekAverageRecord();
            return ApiResponse::response(true, 'Blood Pressure Last week average successfully fetched.', $records);
        } catch (\Exception $e) {
            Log::error('Blood Pressure Last week average fetch failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    public function filter(Request $request)
    {
        try {
            $records = $this->bloodPressureService->filter($request);
            return ApiResponse::response(true, 'Blood Pressure successfully filtered.', $records);
        }catch (\Exception $e) {
            Log::error('Blood Pressure filter failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function export(Request $request)
    {
        try {
            $records = $this->bloodPressureService->export($request);
            return ApiResponse::response(true, 'Blood Pressure successfully exported.',$records);
        }catch (\Exception $e) {
            Log::error('Blood Pressure export failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }
}
