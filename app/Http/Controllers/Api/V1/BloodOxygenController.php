<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BloodOxygen\StoreRequest;
use App\Services\Api\BloodOxygenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BloodOxygenController extends Controller
{
    protected $bloodOxygenService;

    public function __construct(BloodOxygenService $bloodOxygenService)
    {
        $this->bloodOxygenService = $bloodOxygenService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->bloodOxygenService->store($request);
            return ApiResponse::response(true, 'Blood Oxygen was successfully stored.');
        }
        catch (\Exception $e) {
            Log::error('Blood Oxygen Create failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return ApiResponse::response(true, 'Blood Oxygen was successfully deleted.');
    }

    public function history(Request $request)
    {
        return ApiResponse::response(true, 'Blood Oxygen history successfully fetched.');
    }

    public function chartData(Request $request)
    {
        return ApiResponse::response(true, 'Blood Oxygen chart data successfully fetched.');
    }

    public function lastWeekAverage()
    {
        return ApiResponse::response(true, 'Blood Oxygen Last week average successfully fetched.');
    }

    public function filter(Request $request)
    {
        return ApiResponse::response(true, 'Blood Oxygen successfully filtered.');
    }

    public function export(Request $request)
    {
        return ApiResponse::response(true, 'Blood Oxygen successfully exported.');
    }
}
