<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HabitTaskRequest;
use App\Http\Requests\Api\HabitReminder\TaskStoreRequest;
use App\Models\HabitList;
use App\Models\HabitTask;
use App\Services\Api\HabitTaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HabitTaskController extends Controller
{
    protected $profileId, $habitTaskService;

    public function __construct(Request $request, HabitTaskService $habitTaskService)
    {
        $this->profileId = $request->route('profile_id');
        $this->habitTaskService = $habitTaskService;
    }


    public function habitList($request, $id=null)
    {
        try {
            return $this->habitTaskService->getHabitList($this->profileId, $id);
        }
        catch (\Exception $e) {
            Log::error('Habit List fetch failed: ' . $e->getMessage());
            return ApiResponse::serverError();
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        dd($request->json()->all());
        return ApiResponse::response(true, 'Habit Task was successfully added.', $request->json()->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
