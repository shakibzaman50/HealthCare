<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\HydrationReminder\StoreRequest;
use App\Services\Api\HydrationReminderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HydrationReminderController extends Controller
{
    protected $hydrationReminderService;

    public function __construct(HydrationReminderService $hydrationReminderService)
    {
        $this->hydrationReminderService = $hydrationReminderService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->hydrationReminderService->store($request);
            return  ApiResponse::response(true, 'Hydration Reminder was successfully stored.');
        }
        catch (\Exception $e) {
            Log::error('Hydration Reminder Create failed: ' . $e->getMessage());
            return  ApiResponse::serverError();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return ApiResponse::response(true, 'Hydration Reminder was successfully deleted.');
    }

    public function history(Request $request)
    {
        return ApiResponse::response(true, 'Hydration Reminder history successfully fetched.');
    }

    public function chartData(Request $request)
    {
        return ApiResponse::response(true, 'Hydration Reminder chart data successfully fetched.');
    }

    public function lastWeekAverage()
    {
        return ApiResponse::response(true, 'Hydration Reminder Last week average successfully fetched.');
    }

    public function filter(Request $request)
    {
        return ApiResponse::response(true, 'Hydration Reminder successfully filtered.');
    }

    public function export(Request $request)
    {
        return ApiResponse::response(true, 'Hydration Reminder successfully exported.');
    }
}
