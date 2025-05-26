<?php

namespace App\Services\Api;

use App\Helpers\ApiResponse;
use App\Models\HabitList;
use App\Models\HabitTask;

class HabitTaskService
{
    public function getHabitList($profileId, $id=null)
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
            ->orWhere('profile_id', $profileId)
            ->select('id','habit_list_id','name')
            ->get();

        return ApiResponse::response(true, 'Habit List with task', $data);
    }

    public function store($request)
    {

    }
}
