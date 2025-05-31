<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HabitTaskRequest;
use App\Http\Requests\Api\HabitReminder\TaskStoreRequest;
use App\Http\Requests\Api\HabitTracker\HistoryRequest;
use App\Http\Requests\Api\HabitTracker\StoreRequest;
use App\Models\HabitList;
use App\Models\HabitTask;
use App\Services\Api\HabitTaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HabitTaskController extends Controller
{
    protected $profileId, $habitTaskService;

    public function __construct(Request $request)
    {
        $this->profileId = $request->route('profile_id');
        $this->habitTaskService = new HabitTaskService($this->profileId);
    }

    public function habitList($request, $id=null)
    {
        try {
            return $this->habitTaskService->getHabitList($id);
        }
        catch (\Exception $e) {
            Log::error('Habit List fetch failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    public function store(StoreRequest $request)
    {
        return $this->habitTaskService->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($profileId, string $id)
    {
        try {
            return $this->habitTaskService->show($id);
        }catch (\Exception $e) {
            Log::error('Habit Show fetch failed: ' . $e->getMessage());
            return ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return 'Habit Update '.$id;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($profileId, string $id)
    {
        return $this->habitTaskService->delete($id);
    }

    public function habitHistory(HistoryRequest $request)
    {
        try {
            $tasks = $this->habitTaskService->habitHistory($request->date);
            return ApiResponse::response(true, 'Habit History Fetched Successfully', $tasks);
        }catch (\Exception $e) {
            Log::error('Habit History fetch failed: ' . $e->getMessage());
            return ApiResponse::serverError($e->getMessage());
        }
    }
}
