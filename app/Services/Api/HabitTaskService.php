<?php

namespace App\Services\Api;

use App\Helpers\ApiResponse;
use App\Helpers\Helpers;
use App\Models\HabitFrequency;
use App\Models\HabitList;
use App\Models\HabitReminder;
use App\Models\HabitSchedule;
use App\Models\HabitTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HabitTaskService
{
    protected $profileId;

    public function __construct($id)
    {
        $this->profileId = $id;
    }

    public function getHabitList($id=null)
    {
        $habitList = HabitList::active()->select('id','name')->get();
        if ($habitList->isEmpty()) {
            return ApiResponse::serverError('No Habit List Found', 404);
        }

        $id = $id ?? $habitList->first()->id;
        $data['habit_lists'] = $habitList;
        $data['habit_tasks'] = HabitTask::active()
            ->where('habit_list_id', $id)
            ->whereNull('profile_id')
            ->orWhere('profile_id', $this->profileId)
            ->select('id','habit_list_id','name')
            ->get();

        return ApiResponse::response(true, 'Habit List with task', $data);
    }

    protected function storeHabitTask($request) : int
    {
        $icon = Helpers::getFileUrl($request->icon, 'icons/');
        $newHabitTask = HabitTask::create([
            'profile_id' => $this->profileId,
            'name'       => $request->name,
            'icon'       => $icon,
        ]);
        return $newHabitTask->id;
    }

    protected function storeHabitSchedule($request, int $taskId) : int
    {
        $newSchedule = HabitSchedule::create([
            'profile_id'    => $this->profileId,
            'habit_task_id' => $taskId,
            'type'          => $request->type,
            'duration'      => $request->duration,
            'color'         => $request->color,
            'end_date'      => $request->end_date,
            'description'   => $request->description,
            'is_repeat'     => $request->is_repeat ? 1 : 0,
            'till_turn_off' => $request->till_turn_off ? 1 : 0,
        ]);
        return $newSchedule->id;
    }

    protected function storeHabitFrequency($frequency, $scheduleId)
    {
        $newFrequency = HabitFrequency::create([
            'habit_schedule_id' => $scheduleId,
            'day'               => $frequency['day'],
            'how_many_times'    => $frequency['how_many_times'],
        ]);

        foreach ($frequency['reminder_times'] as $reminder) {
            $this->storeHabitReminder($reminder, $newFrequency->id);
        }
    }

    protected function storeHabitReminder($reminder, $frequencyId)
    {
        HabitReminder::create([
            'habit_frequency_id' => $frequencyId,
            'reminder_time'      => $reminder['time'],
        ]);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            if ($request->habit_list_id) {
                $newTaskId = $this->storeHabitTask($request);
            }
            $taskId = $newTaskId ?? $request->habit_task_id;
            $newScheduleId = $this->storeHabitSchedule($request, $taskId);

            foreach ($request->frequency as $frequency) {
                $this->storeHabitFrequency($frequency, $newScheduleId);
            }
            DB::commit();
            return ApiResponse::response(true, 'Habit Task Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Habit task create error '. $e->getMessage());
            return ApiResponse::serverError($e->getMessage());
        }
    }
}
