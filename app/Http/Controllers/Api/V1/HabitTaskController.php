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
//        return response()->json($request->all());
//        return response()->json([
//            'success'   => true,
//            'schedule'  => $request->frequency,
//        ]);


//        foreach ($request->frequency as $frequency) {
//            return response()->json([
//                'success'   => true,
//                'day' => $frequency['day'],
//                'how_many_times' => $frequency['how_many_times'],
//                'reminder_times' => $frequency['reminder_times'],
//                'time0' => $frequency['reminder_times'][0]['time'],
//                'time1' => $frequency['reminder_times'][1]['time'],
//                'frequency' => $frequency,
//            ]);
//        }

//        foreach ($request->frequency[0]['reminder_times'] as $reminder) {
//            return response()->json([
//                'time'     => $reminder['time'],
//                'reminder' => $reminder,
//            ]);
//        }

        return $this->habitTaskService->store($request);
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
