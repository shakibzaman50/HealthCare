<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BloodPressure\StoreRequest;
use App\Services\Api\BloodPressureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BloodPressureController extends Controller
{
    protected $bloodPressureService;

    public function __construct(BloodPressureService $bloodPressureService)
    {
        $this->bloodPressureService = $bloodPressureService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->bloodPressureService->store($request);
            return  ApiResponse::response(true, 'Blood Pressure was successfully stored.');
        }
        catch (\Exception $e) {
            Log::error('Blood Pressure Create failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return ApiResponse::response(true, 'Blood Pressure was successfully deleted.');
    }

    public function history(Request $request)
    {
        return ApiResponse::response(true, 'Blood Pressure history successfully fetched.');
    }

    public function chartData(Request $request)
    {
        return ApiResponse::response(true, 'Blood Pressure chart data successfully fetched.');
    }

    public function lastWeekAverage()
    {
        return ApiResponse::response(true, 'Blood Pressure Last week average successfully fetched.');
    }

    public function filter(Request $request)
    {
        return ApiResponse::response(true, 'Blood Pressure successfully filtered.');
    }

    public function export(Request $request)
    {
        return ApiResponse::response(true, 'Blood Pressure successfully exported.');
    }
}
