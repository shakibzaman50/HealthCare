<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\HeartRate\StoreRequest;
use App\Services\Api\HeartRateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HeartRateController extends Controller
{
    protected $heartRateService;

    public function __construct(HeartRateService $heartRateService)
    {
        $this->heartRateService = $heartRateService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->heartRateService->store($request);
            return ApiResponse::response(true, 'Heart Rate was successfully stored.');
        }
        catch (\Exception $e) {
            Log::error('Heart Rate Create failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return ApiResponse::response(true, 'Heart Rate was successfully deleted.');
    }

    public function history(Request $request)
    {
        return ApiResponse::response(true, 'Heart Rate history successfully fetched.');
    }

    public function chartData(Request $request)
    {
        return ApiResponse::response(true, 'Heart Rate chart data successfully fetched.');
    }

    public function lastWeekAverage()
    {
        return ApiResponse::response(true, 'Heart Rate Last week average successfully fetched.');
    }

    public function filter(Request $request)
    {
        return ApiResponse::response(true, 'Heart Rate successfully filtered.');
    }

    public function export(Request $request)
    {
        return ApiResponse::response(true, 'Heart Rate successfully exported.');
    }
}
