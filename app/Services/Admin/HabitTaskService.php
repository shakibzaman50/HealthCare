<?php

namespace App\Services\Admin;

use App\Helpers\Helpers;
use App\Models\HabitTask;
use Illuminate\Support\Str;

class HabitTaskService
{
    protected function checkTrashed($request)
    {
        return HabitTask::withTrashed()
            ->where([
                'name'          => Str::squish($request->name),
                'habit_list_id' => $request->habit_list_id,
            ])
            ->first() ?? null;
    }

    public function create($request) : HabitTask
    {
        $trashedTask = $this->checkTrashed($request);

        if($trashedTask) {
            $trashedTask->restore();
            return $trashedTask;
        }
        else{
            $icon = Helpers::getFileUrl($request->icon, 'icons/');
            return HabitTask::create([
                'habit_list_id' => $request->habit_list_id,
                'name'          => $request->name,
                'is_active'     => $request->has('is_active'),
                'icon'          => $icon
            ]);
        }
    }

    public function update(HabitTask $habitTask, $request): HabitTask
    {
        $emoji = Helpers::getFileUrl($request->icon, 'icons/', $habitTask->icon);
        $habitTask->update([
            'habit_list_id' => $request->habit_list_id,
            'name'          => $request->name,
            'is_active'     => $request->has('is_active'),
            'emoji'         => $emoji
        ]);
        return $habitTask;
    }

    public function delete(HabitTask $habitTask): bool
    {
        return $habitTask->delete();
    }
}
